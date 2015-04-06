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
 * Any bootstrappinh logic, that is related to the application should be here
 *
 * TODO: routes should be generated from config
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
        $app->get('/services/view/{id}', 'service.controller::read');
        $app->post('/services/view/{id}/comment/create', 'service.controller::processCreateComment');
        $app->get('/services/edit/{id}', 'service.controller::update');
        $app->post('/services/edit/{id}', 'service.controller::processUpdate');
        $app->get('/services/delete/{id}', 'service.controller::delete');
        $app->get('/services/print/{id}', 'service.controller::pdf');

        $app->get('/login', 'Indigo\Service\Controller\AuthController::login');
        $app->post('/login', 'Indigo\Service\Controller\AuthController::processLogin');

        $app->getEmitter()->addListener('request.received', $app['Indigo\Service\Listener\BaseUrl']);

        return $app;
    }
}
