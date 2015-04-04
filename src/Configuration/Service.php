<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Service\Configuration;

use Proton\Crud\Configuration;

/**
 * Service configuration
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Service extends Configuration
{
    /**
     * @var string
     */
    protected $serviceName = 'service';

    /**
     * @var string
     */
    protected $controllerClass = 'Indigo\Service\Controller\ServiceController';

    /**
     * @var string
     */
    protected $entityClass = 'Indigo\Service\Entity\Service';

    /**
     * @var string
     */
    protected $route = '/services';

    /**
     * @var array
     */
    protected $handlerMap = [
        'createEntity' => 'Indigo\Service\CommandHandler\ServiceCreator',
        'updateEntity' => 'Indigo\Service\CommandHandler\ServiceUpdater',
        'loadEntity'   => 'Indigo\Service\QueryHandler\ServiceLoader',
    ];

    /**
     * @var array
     */
    protected $views = [
        'create' => 'service/create.twig',
        'read'   => 'service/read.twig',
        'update' => 'service/update.twig',
        'list'   => 'service/list.twig',
    ];

    /**
     * Noop
     */
    public function __construct()
    {
    }
}
