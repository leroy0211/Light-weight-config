<?php

namespace Flexsounds\Component\LightWeightConfig\Tests;

use Flexsounds\Component\LightWeightConfig\Config;

/**
 * Created by PhpStorm.
 * User: leroy
 * Date: 01/09/16
 * Time: 11:49
 */
class DummyTest extends \PHPUnit_Framework_TestCase
{


    public function testTralala()
    {
        $loader = new Config(__DIR__);

        $loader->addParameter('johnslastname', 'fagget');

        $data = $loader->load('config_dev.yml');

        var_dump($data);
    }

}