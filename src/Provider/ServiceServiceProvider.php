<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Service\Provider;

use Indigo\Service\Controller\ServiceController;
use League\Container\ServiceProvider;
use League\Tactician\Container\ContainerLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
// use Proton\Crud\CrudServiceProvider;

/**
 * Provides Service CRUD services
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ServiceServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        'Indigo\Service\Controller\ServiceController',
    ];

    /**
     * Provides handler map
     *
     * @var array
     */
    protected $handlerMap = [
        'Proton\Crud\Command\CreateEntity'  => 'Indigo\Service\CommandHandler\ServiceCreator',
        'Proton\Crud\Command\UpdateEntity'  => 'Indigo\Service\CommandHandler\ServiceUpdater',
        'Proton\Crud\Command\DeleteEntity'  => 'Proton\Crud\CommandHandler\DoctrineEntityRemover',
        'Proton\Crud\Query\FindEntity'      => 'Proton\Crud\QueryHandler\DoctrineEntityFinder',
        'Proton\Crud\Query\FindAllEntities' => 'Proton\Crud\QueryHandler\DoctrineAllEntityFinder',
        'Proton\Crud\Query\LoadEntity'      => 'Indigo\Service\QueryHandler\ServiceLoader',
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->getContainer()->add('Indigo\Service\Controller\ServiceController', function($twig) {
            $locator = new ContainerLocator(
                $this->getContainer(),
                $this->handlerMap
            );

            $inflector = new HandleInflector;

            $middleware = new CommandHandlerMiddleware($locator, $inflector);

            $commandBus = $this->getContainer()->get('League\Tactician\CommandBus', [[$middleware]]);

            return new ServiceController($twig, $commandBus);
        })
        ->withArgument('Twig_Environment');
    }
}
