<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Service;

use Proton\Application;

/**
 * Bootstraps the application
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Bootstrap
{
    /**
     * Bootstraps the application
     *
     * @param Application $app
     *
     * @return Application
     */
    public function load(Application $app)
    {
        $app->get('/', 'Indigo\Service\Controller\MainController::index');

        $app->get('/services', 'Indigo\Service\Controller\ServiceController::index');
        $app->get('/services/create', 'Indigo\Service\Controller\ServiceController::create');
        $app->post('/services/create', 'Indigo\Service\Controller\ServiceController::processCreate');
        $app->get('/services/edit/{id}', 'Indigo\Service\Controller\ServiceController::update');
        $app->post('/services/edit/{id}', 'Indigo\Service\Controller\ServiceController::processUpdate');
        $app->get('/services/delete/{id}', 'Indigo\Service\Controller\ServiceController::delete');

        $app->get('/login', 'Indigo\Service\Controller\AuthController::login');
        $app->post('/login', 'Indigo\Service\Controller\AuthController::processLogin');

        return $app;
    }
}
