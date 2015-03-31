<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Proton\Application;
use League\Container\Container;
use Symfony\Component\Yaml\Yaml;

$services = require __DIR__.'/services.php';
$container = new Container($services);

$app = new Application;
$app->setContainer($container);

if (is_file(__DIR__.'/parameters.yml')) {
    foreach (Yaml::parse(__DIR__.'/parameters.yml') as $config => $value) {
        $app->setConfig($config, $value);
    }
}

// protect this config from rewrite
$app->setConfig('path', __DIR__.'/');

return $app;
