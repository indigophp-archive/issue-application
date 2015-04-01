<?php

namespace spec\Indigo\Service\CommandHandler;

use Doctrine\ORM\EntityManagerInterface;
use Indigo\Hydra\Hydrator;
use Proton\Crud\Command\CreateEntity;
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

    function it_handles_a_create_command(CreateEntity $command, EntityManagerInterface $em, Hydrator $hydra)
    {
        $entity = 'Indigo\Service\Entity\Service';

        $command->getData()->willReturn([
            'estimatedEnd' => 'now',
        ]);

        $command->setData(Argument::type('array'))->shouldBeCalled();
        $command->getEntityClass()->willReturn($entity);

        $hydra->hydrate(Argument::type($entity), Argument::type('array'))->shouldBeCalled();
        $hydra->extract(Argument::type($entity))->willReturn([]);
        $em->persist(Argument::type($entity))->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->handle($command);
    }
}
