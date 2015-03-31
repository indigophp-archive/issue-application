<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

defined('ROOTPATH') or define('ROOTPATH', realpath(__DIR__.'/../'));

require ROOTPATH.'/vendor/autoload.php';

$app = require ROOTPATH.'/app/bootstrap.php';

Stack\run($app);
