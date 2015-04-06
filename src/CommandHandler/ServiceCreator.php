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

use Proton\Crud\Command\CreateEntity;
use Proton\Crud\CommandHandler\DoctrineEntityCreator;

/**
 * Handles service creation logic
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ServiceCreator
{
    /**
     * @var DoctrineEntityCreator
     */
    protected $delegatedHandler;

    /**
     * @param DoctrineEntityCreator $delegatedHandler
     */
    public function __construct(DoctrineEntityCreator $delegatedHandler)
    {
        $this->delegatedHandler = $delegatedHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(CreateEntity $command)
    {
        $data = $command->getData();

        $data['estimatedEnd'] = new \DateTime($data['estimatedEnd']);
        $data['createdAt'] = new \DateTime('now');

        $command->setData($data);

        $this->delegatedHandler->handle($command);
    }
}
