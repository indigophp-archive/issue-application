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
use League\Container\Container;
use Proton\Application;
use Symfony\Component\Yaml\Yaml;

/**
 * This file is responsible for creating the application and
 * loading all resources which are necessary for the application to run.
 *
 * These include:
 *  - Loading environment
 *  - Setting up dependency container
 *  - Loading configuration
 */


/**
 * The application needs a root to work correctly,
 * but it isn't the application's task, it is an environment detail
 */
if (!defined('APP_ROOT')) {
    throw new \RuntimeException('The APP_ROOT must be defined');
}


/**
 * Loading environment
 *
 * This is the applications responsibility as it can't work without it
 * The environment file should be in the APP_ROOT in development
 */
$dotenv = new Dotenv;

// To avoid the overhead caused by file loading, this is optional in production
if (APP_ENV == 'development') {
    $dotenv->load(APP_ROOT);
}

// Check the required variables
$dotenv->required(['APP_ROOT', 'APP_CONFIG']);


/**
 * Setting up dependency container
 */
$services = require __DIR__.'/services.php';
$container = new Container($services);


/**
 * Instantiating the application
 */
$app = new Application(getenv('DEBUG') !== 'false');
$app->setContainer($container);


/**
 * Loading configuration
 *
 * We are trying to load the file as an absolute path and as a relative one to the APP_ROOT
 *
 *  or is_file($configFile = APP_ROOT.'/'.trim($configFile))
 *
 * UPDATE: APP_ROOT is now set in the environment as well
 */
if (is_file($configFile = getenv('APP_CONFIG'))) {
    foreach (Yaml::parse($configFile) as $config => $value) {
        $app->setConfig($config, $value);
    }
}

// The application path is protected from being overwritten
$app->setConfig('path', __DIR__);


return $app;
