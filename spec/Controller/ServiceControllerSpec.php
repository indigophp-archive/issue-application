<?php

namespace spec\Indigo\Service\Controller;

use League\Tactician\CommandBus;
use Proton\Crud\Configuration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ServiceControllerSpec extends ObjectBehavior
{
    function let(\Twig_Environment $twig, CommandBus $commandBus, Configuration $config)
    {
        $this->beConstructedWith($twig, $commandBus, $config);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\Controller\ServiceController');
    }
}
