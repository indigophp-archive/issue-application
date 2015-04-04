<?php

namespace spec\Indigo\Service\CommandHandler;

use Doctrine\ORM\EntityManagerInterface;
use Indigo\Hydra\Hydrator;
use Proton\Crud\Command\CreateEntity;
use Proton\Crud\Configuration;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ServiceCreatorSpec extends ObjectBehavior
{
    function let(EntityManagerInterface $em, Hydrator $hydra)
    {
        $this->beConstructedWith($em, $hydra);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\CommandHandler\ServiceCreator');
    }

    function it_handles_a_create_command(CreateEntity $command, Configuration $config, EntityManagerInterface $em, Hydrator $hydra)
    {
        $entityClass = 'Indigo\Service\Entity\Service';

        $config->getEntityClass()->willReturn($entityClass);

        $command->getData()->willReturn([
            'estimatedEnd' => 'now',
        ]);
        $command->getConfig()->willReturn($config);

        $command->setData(Argument::type('array'))->shouldBeCalled();

        $hydra->hydrate(Argument::type($entityClass), Argument::type('array'))->shouldBeCalled();
        $hydra->extract(Argument::type($entityClass))->willReturn([]);
        $em->persist(Argument::type($entityClass))->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->handle($command);
    }
}
