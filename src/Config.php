<?php
/**
 * Created by PhpStorm.
 * User: leroy
 * Date: 01/09/16
 * Time: 11:54
 */

namespace Flexsounds\Component\LightWeightConfig;


use Symfony\Component\Yaml\Yaml;

class Config
{
    private $resource;

    private $parameters = array();

    public function __construct($resource = null)
    {
        $this->resource = $resource;
    }

    public function addParameter($name, $value=null)
    {
        $this->parameters[$name] = $value;
        return $this;
    }

    public function load($file)
    {
        $content = $this->loadYaml($file);
        $this->parseParameters($content);
        return $content;
    }

    private function getFile($file)
    {
        return realpath(rtrim($this->resource, "/") . "/" . ltrim($file, "/"));
    }

    private function loadYaml($file)
    {
        try{
            $resource = $this->getFile($file);
            $content = Yaml::parse(file_get_contents($resource));

            if(isset($content['imports'])){
                foreach($content['imports'] as $import){
                    if($extraContent = $this->loadYaml($import['resource'])){
                        $content = array_replace_recursive($extraContent, $content);
                    }
                }
            }

            if(isset($content['parameters'])){
                foreach($content['parameters'] as $key => $value){
                    $this->parameters[$key] = $value;
                }
            }

            return $content;
        }catch(\Symfony\Component\Yaml\Exception\ParseException $e){
            echo sprintf("Unable to parse the YAML string: %s", $e->getMessage());
            return array();
        }
    }

    private function parseParameters(&$content)
    {
        array_walk_recursive($content, function(&$val, $key){
            $matches = null;
            preg_match('/\%(.*?)\%/', $val, $matches);
            $param = isset($matches[1]) ? $matches[1] : false;
            if($param){
                if (isset($this->parameters[$param])) {
                    $val = str_replace("%$param%", $this->parameters[$param], $val);
                }
            }
        });
    }


}