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

        $app->get('/services', 'service.controller::index');
        $app->get('/services/create', 'service.controller::create');
        $app->post('/services/create', 'service.controller::processCreate');
        $app->get('/services/edit/{id}', 'service.controller::update');
        $app->post('/services/edit/{id}', 'service.controller::processUpdate');
        $app->get('/services/delete/{id}', 'service.controller::delete');

        $app->get('/login', 'Indigo\Service\Controller\AuthController::login');
        $app->post('/login', 'Indigo\Service\Controller\AuthController::processLogin');

        return $app;
    }
}
