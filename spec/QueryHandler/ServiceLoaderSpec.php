<?php

namespace spec\Indigo\Service\QueryHandler;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Indigo\Hydra\Hydrator;
use Indigo\Service\Entity\Service;
use Proton\Crud\Query\LoadEntity;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ServiceLoaderSpec extends ObjectBehavior
{
    function let(EntityManagerInterface $em, Hydrator $hydra)
    {
        $this->beConstructedWith($em, $hydra);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\QueryHandler\ServiceLoader');
    }

    function it_handles_a_load_query(Service $entity, EntityRepository $repository, LoadEntity $query, EntityManagerInterface $em, Hydrator $hydra)
    {
        $entityClass = 'Indigo\Service\Entity\Service';

        $query->getEntityClass()->willReturn($entityClass);
        $query->getId()->willReturn(1);

        $em->getRepository($entityClass)->willReturn($repository);
        $repository->find(1)->willReturn($entity);
        $hydra->extract(Argument::type($entityClass))->willReturn([
            'estimatedEnd' => new \DateTime('now'),
        ]);

        $this->handle($query);
    }
}
