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

use Proton\Crud\CrudServiceProvider;

/**
 * Provides Service CRUD services
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ServiceServiceProvider extends CrudServiceProvider
{
    /**
     * @var string
     */
    protected $serviceName = 'service';

    /**
     * @var string
     */
    protected $controller = 'Indigo\Service\Controller\ServiceController';

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
}
