<?php

namespace spec\Indigo\Service\CommandHandler;

use Doctrine\ORM\EntityManagerInterface;
use Indigo\Hydra\Hydrator;
use Indigo\Service\Entity\Service;
use Proton\Crud\Command\UpdateEntity;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ServiceUpdaterSpec extends ObjectBehavior
{
    function let(EntityManagerInterface $em, Hydrator $hydra)
    {
        $this->beConstructedWith($em, $hydra);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\CommandHandler\ServiceUpdater');
    }

    function it_handles_an_update_command(Service $entity, UpdateEntity $command, EntityManagerInterface $em, Hydrator $hydra)
    {
        $command->getEntity()->willReturn($entity);

        $command->getData()->willReturn([
            'estimatedEnd' => 'now',
        ]);

        $command->setData(Argument::type('array'))->shouldBeCalled();

        $hydra->hydrate($entity, Argument::type('array'))->shouldBeCalled();
        $hydra->extract($entity)->willReturn([]);
        $em->flush()->shouldBeCalled();

        $this->handle($command);
    }
}
