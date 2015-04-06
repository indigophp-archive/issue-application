<?php

namespace spec\Indigo\Service\Entity;

use Indigo\Service\Entity\Service;
use Indigo\Service\Entity\User;
use PhpSpec\ObjectBehavior;

class CommentSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Secret comment', true);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\Entity\Comment');
    }

    function it_does_not_have_an_author_by_default()
    {
        $this->getAuthor()->shouldReturn(null);
    }

    function it_accepts_an_author(User $author)
    {
        $this->shouldImplement('Indigo\Doctrine\Entity\HasAuthor');

        $this->setAuthor($author);

        $this->getAuthor()->shouldReturn($author);
    }

    function it_does_not_have_a_service_by_default()
    {
        $this->getService()->shouldReturn(null);
    }

    function it_accepts_a_service(Service $service)
    {
        $this->setService($service);

        $this->getService()->shouldReturn($service);
    }

    function it_has_a_comment()
    {
        $this->getComment()->shouldReturn('Secret comment');
    }

    function it_accepts_a_comment()
    {
        $this->setComment('More secret comment');

        $this->getComment()->shouldReturn('More secret comment');
    }

    function it_does_not_accept_non_string_or_empty_comment()
    {
        $this->shouldThrow('InvalidArgumentException')->duringSetComment(false);
        $this->shouldThrow('InvalidArgumentException')->duringSetComment('');
    }

    function it_checks_if_the_comment_is_internal()
    {
        $this->isInternal()->shouldReturn(true);
    }

    function it_allows_to_set_the_internal_state()
    {
        $this->setInternal(false);

        $this->isInternal()->shouldReturn(false);
    }

    function it_does_not_accept_non_boolean_internal_state()
    {
        $this->shouldThrow('InvalidArgumentException')->duringSetInternal('false');
    }

    function it_has_a_creation_time()
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }
}
