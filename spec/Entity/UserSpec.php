<?php

namespace spec\Indigo\Service\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('username', 'email@domain.com', 'password');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\Entity\User');
        $this->shouldImplement('Indigo\Guardian\Caller\User');
        $this->shouldImplement('Indigo\Guardian\Caller\HasLoginToken');
    }

    function it_has_an_id()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_a_login_token()
    {
        $this->getLoginToken()->shouldReturn(null);
    }

    function it_has_a_username()
    {
        $this->getUsername()->shouldReturn('username');
    }

    function it_has_an_email()
    {
        $this->getEmail()->shouldReturn('email@domain.com');
    }

    function it_has_a_password()
    {
        $this->getPassword()->shouldReturn('password');
    }
}
