<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Indigo\Service\Bootstrap;

/**
 * This file is responsible for any application initialization before running it
 *
 * Environment, language, routes, wrappers, event listeners should all be set here
 */

/**
 * Loading environment
 *
 * This should be done right before the application is loaded, since the application relies on the environment
 */
$dotenv = dotenv();

// To avoid the overhead caused by file loading, this is optional in production
if (APP_ENV == 'development') {
    $dotenv->load(APP_ROOT);
}

// Get the application
$app = require __DIR__.'/app.php';

// Set locale based on environment
setlocale(LC_ALL, getenv('LANG'));

$bootstrap = new Bootstrap;

$app = $bootstrap->load($app);

return $app['Indigo\Guardian\Stack\Authentication'];
