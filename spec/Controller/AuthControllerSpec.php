<?php

namespace spec\Indigo\Service\Controller;

use Indigo\Guardian\Service\Login;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthControllerSpec extends ObjectBehavior
{
    function let(\Twig_Environment $twig, Login $login)
    {
        $this->beConstructedWith($twig, $login);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\Controller\AuthController');
    }

    function it_logs_in_a_user(\Twig_Environment $twig, Request $request, Response $response)
    {
        $twig->render('login.twig', Argument::type('array'))->willReturn('template');
        $response->setContent('template')->shouldBeCalled();

        $this->login($request, $response, []);
    }
}
