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

$app = require __DIR__.'/app.php';

$bootstrap = new Bootstrap;

$app = $bootstrap->load($app);

$app->getEmitter()->addListener('request.received', $container->get('Indigo\Service\Listener\RootPath'));

return $container->get('Indigo\Guardian\Stack\Authentication');
