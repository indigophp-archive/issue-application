<?php

namespace spec\Indigo\Service\QueryHandler;

use Proton\Crud\QueryHandler\DoctrineEntityLoader;
use Indigo\Service\Entity\Service;
use Proton\Crud\Configuration;
use Proton\Crud\Query\LoadEntity;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ServiceLoaderSpec extends ObjectBehavior
{
    function let(DoctrineEntityLoader $delegatedHandler)
    {
        $this->beConstructedWith($delegatedHandler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\QueryHandler\ServiceLoader');
    }

    function it_handles_a_load_query(Service $entity, LoadEntity $query, DoctrineEntityLoader $delegatedHandler)
    {
        $entityClass = 'Indigo\Service\Entity\Service';

        $query->getEntityClass()->willReturn($entityClass);
        $query->getId()->willReturn(1);

        $delegatedHandler->handle($query)->willReturn([
            'estimatedEnd' => new \DateTime('now'),
        ]);

        $this->handle($query);
    }
}
