<?php

namespace spec\Indigo\Service\CommandHandler;

use Proton\Crud\CommandHandler\DoctrineEntityCreator;
use Proton\Crud\Command\CreateEntity;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ServiceCreatorSpec extends ObjectBehavior
{
    function let(DoctrineEntityCreator $delegatedHandler)
    {
        $this->beConstructedWith($delegatedHandler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\CommandHandler\ServiceCreator');
    }

    function it_handles_a_create_command(CreateEntity $command, DoctrineEntityCreator $delegatedHandler)
    {
        $entityClass = 'Indigo\Service\Entity\Service';

        $command->getData()->willReturn([
            'estimatedEnd' => 'now',
        ]);
        $command->getEntityClass()->willReturn($entityClass);

        $command->setData(Argument::type('array'))->shouldBeCalled();

        $delegatedHandler->handle($command)->shouldBeCalled();

        $this->handle($command);
    }
}
