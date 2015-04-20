<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Dotenv\Dotenv;
use Indigo\Service\Bootstrap;
use League\Container\Container;
use Proton\Application;
use Stack\Builder;
use Symfony\Component\Yaml\Yaml;

if (!defined('APP_ROOT')) {
    throw new \RuntimeException('The application root must be defined');
}

if (!defined('APP_ENV')) {
    throw new \RuntimeException('The application environment must be defined');
}

/**
 * This file is responsible for creating the application and
 * loading all resources which are necessary for the application to run.
 *
 * These include:
 *  - Environment loading
 *  - Environment check
 *  - Dependency container setup
 *  - Configuration loading (optional)
 */

/**
 * Loading environment
 *
 * This should be done right before the application is loaded, since the application relies on the environment
 */
$dotenv = new Dotenv;

// To avoid the overhead caused by file loading, this is optional in production
if (APP_ENV == 'development') {
    $dotenv->load(APP_ROOT);
}

/**
 * Checking environment
 *
 * The environment is already loaded, now it should be checked
 */
$dotenv->required(['APP_ROOT', 'APP_CONFIG', 'WKHTMLTOPDF']);

/**
 * Setting up dependency container
 */
$diConfig = require __DIR__.'/di.php';
$container = new Container($diConfig);

/**
 * Instantiating the application
 */
$app = new Application;
$app->setContainer($container);
$app['env'] = $dotenv;

/**
 * Loading configuration
 */
if (is_file($configFile = getenv('APP_CONFIG'))) {
    foreach (Yaml::parse($configFile) as $config => $value) {
        $app->setConfig($config, $value);
    }
}

// The application path is protected from being overwritten
// Should be placed after configuration loading
$app->setConfig('path', __DIR__);

// Set locale based on environment
setlocale(LC_ALL, getenv('LANG'));

$bootstrap = new Bootstrap;

$app = $bootstrap->load($app);


$app['stack'] = new Builder;

$app['stack']->push(
    'Indigo\Guardian\Stack\Authentication',
    $app['Indigo\Guardian\Service\Resume'],
    $app['Indigo\Guardian\Service\Logout'],
    ['delegateCaller' => true]
);


return $app;
