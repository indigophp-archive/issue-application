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
 * This file is responsible for any further application initialization before running it
 *
 * Language, routes, wrappers, event listeners should all be set here
 */

// Get the application
$app = require __DIR__.'/app.php';

// Set locale based on environment
setlocale(LC_ALL, getenv('LANG'));

$bootstrap = new Bootstrap;

$app = $bootstrap->load($app);

return $app['Indigo\Guardian\Stack\Authentication'];
