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
use Proton\Tools\Listener\BaseUri;

/**
 * Bootstraps the application
 *
 * Any bootstrapping logic, that is related to the application should be here
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

        $app->get('/services', 'Indigo\Service\Controller\ServiceController::listAction');
        $app->get('/services/create', 'Indigo\Service\Controller\ServiceController::createAction');
        $app->post('/services', 'Indigo\Service\Controller\ServiceController::create');
        $app->get('/services/{id}', 'Indigo\Service\Controller\ServiceController::read');
        $app->post('/services/{id}/comment', 'Indigo\Service\Controller\ServiceController::createComment');
        $app->get('/services/{id}/edit', 'Indigo\Service\Controller\ServiceController::updateAction');
        $app->post('/services/{id}', 'Indigo\Service\Controller\ServiceController::update');
        $app->delete('/services/{id}', 'Indigo\Service\Controller\ServiceController::delete');
        $app->get('/services/{id}/print', 'Indigo\Service\Controller\ServiceController::pdf');

        $app->get('/login', 'Indigo\Service\Controller\AuthController::login');
        $app->post('/login', 'Indigo\Service\Controller\AuthController::processLogin');

        $baseUriListener = new BaseUri;
        $baseUriListener->setApplication($app);

        $app->subscribe('request.received', $baseUriListener);

        return $app;
    }
}
