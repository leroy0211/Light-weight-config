<?php
/** @var \Composer\Autoload\ClassLoader $autoloader */
$autoloader = require_once(realpath(__DIR__."/../vendor/autoload.php"));
$autoloader->addPsr4('Flexsounds\Component\LightWeightConfig\Tests\\', __DIR__);
