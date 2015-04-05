<?php

namespace spec\Indigo\Service\CommandHandler;

use Proton\Crud\CommandHandler\DoctrineEntityUpdater;
use Indigo\Service\Entity\Service;
use Proton\Crud\Command\UpdateEntity;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ServiceUpdaterSpec extends ObjectBehavior
{
    function let(DoctrineEntityUpdater $delegatedHandler)
    {
        $this->beConstructedWith($delegatedHandler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\CommandHandler\ServiceUpdater');
    }

    function it_handles_an_update_command(Service $entity, UpdateEntity $command, DoctrineEntityUpdater $delegatedHandler)
    {
        $command->getEntity()->willReturn($entity);

        $command->getData()->willReturn([
            'estimatedEnd' => 'now',
        ]);

        $command->setData(Argument::type('array'))->shouldBeCalled();

        $delegatedHandler->handle($command)->shouldBeCalled();

        $this->handle($command);
    }
}
