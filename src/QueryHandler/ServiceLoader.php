<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Service\QueryHandler;

use Proton\Crud\Query\LoadEntity;
use Proton\Crud\QueryHandler\DoctrineEntityLoader;

/**
 * Handles service loading logic
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ServiceLoader extends DoctrineEntityLoader
{
    /**
     * @var DoctrineEntityLoader
     */
    protected $delegatedHandler;

    /**
     * @param DoctrineEntityLoader $delegatedHandler
     */
    public function __construct(DoctrineEntityLoader $delegatedHandler)
    {
        $this->delegatedHandler = $delegatedHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(LoadEntity $query)
    {
        $data = $this->delegatedHandler->handle($query);

        $data['estimatedEnd'] = $data['estimatedEnd']->format('Y-m-d');

        return $data;
    }
}
