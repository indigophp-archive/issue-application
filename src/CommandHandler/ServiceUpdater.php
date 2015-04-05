<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Service\CommandHandler;

use Proton\Crud\Command\UpdateEntity;
use Proton\Crud\CommandHandler\DoctrineEntityUpdater;

/**
 * Handles service update logic
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ServiceUpdater
{
    /**
     * @var DoctrineEntityUpdater
     */
    protected $delegatedHandler;

    /**
     * @param DoctrineEntityUpdater $delegatedHandler
     */
    public function __construct(DoctrineEntityUpdater $delegatedHandler)
    {
        $this->delegatedHandler = $delegatedHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(UpdateEntity $command)
    {
        $data = $command->getData();

        $data['estimatedEnd'] = new \DateTime($data['estimatedEnd']);

        $command->setData($data);

        $this->delegatedHandler->handle($command);
    }
}
