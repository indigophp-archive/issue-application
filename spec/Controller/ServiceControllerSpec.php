<?php

namespace spec\Indigo\Service\Controller;

use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ServiceControllerSpec extends ObjectBehavior
{
    function let(\Twig_Environment $twig, CommandBus $commandBus)
    {
        $this->beConstructedWith($twig, $commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\Controller\ServiceController');
    }

    function it_shows_services(\Twig_Environment $twig, CommandBus $commandBus, Request $request, Response $response)
    {
        $commandBus->handle(Argument::type('Proton\Crud\Query\FindAllEntities'))->willReturn([]);
        $twig->render('service/list.twig', ['entities' => []])->willReturn('template');
        $response->setContent('template')->shouldBeCalled();

        $this->index($request, $response, []);
    }
}
