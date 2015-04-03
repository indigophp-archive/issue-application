<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

defined('APP_ROOT') or define('APP_ROOT', realpath(__DIR__.'/../'));
putenv('APP_ROOT='.APP_ROOT);

require APP_ROOT.'/vendor/autoload.php';

$app = require APP_ROOT.'/app/bootstrap.php';

Stack\run($app);
