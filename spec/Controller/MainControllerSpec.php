<?php

namespace spec\Indigo\Service\Controller;

use Indigo\Guardian\Service\Login;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MainControllerSpec extends ObjectBehavior
{
    function let(\Twig_Environment $twig)
    {
        $this->beConstructedWith($twig);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\Controller\MainController');
    }

    function it_shows_the_main_page(\Twig_Environment $twig, Request $request, Response $response)
    {
        $twig->render('index.twig')->willReturn('template');
        $response->setContent('template')->shouldBeCalled();

        $this->index($request, $response, []);
    }
}
