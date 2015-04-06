<?php

namespace spec\Indigo\Service\Entity;

use Indigo\Service\Entity\Comment;
use Indigo\Service\Entity\User;
use PhpSpec\ObjectBehavior;

class ServiceSpec extends ObjectBehavior
{
    function let(\DateTime $estimatedEnd)
    {
        $this->beConstructedWith(
            'John Doe',
            '+123456789',
            'john.doe@domain.com',
            $estimatedEnd
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\Entity\Service');
    }

    function it_has_an_id()
    {
        $this->getId()->shouldReturn(null);
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

    function it_has_comments(Comment $comment)
    {
        $this->addComment($comment);

        $this->getComments()->shouldImplement('Doctrine\Common\Collections\Collection');
        $this->getPublicComments()->shouldImplement('Doctrine\Common\Collections\Collection');
        $this->getInternalComments()->shouldImplement('Doctrine\Common\Collections\Collection');
    }

    function it_accepts_a_comment(Comment $comment)
    {
        $this->addComment($comment);
    }

    function it_has_a_customer_name()
    {
        $this->getCustomerName()->shouldReturn('John Doe');
    }

    function it_accepts_a_customer_name()
    {
        $this->setCustomerName('Jane Doe');

        $this->getCustomerName()->shouldReturn('Jane Doe');
    }

    function it_does_not_accept_a_non_string_or_empty_customer_name()
    {
        $this->shouldThrow('InvalidArgumentException')->duringSetCustomerName(false);
        $this->shouldThrow('InvalidArgumentException')->duringSetCustomerName('');
    }

    function it_has_a_customer_phone()
    {
        $this->getCustomerPhone()->shouldReturn('+123456789');
    }

    function it_accepts_a_customer_phone()
    {
        $this->setCustomerPhone('+987654321');

        $this->getCustomerPhone()->shouldReturn('+987654321');
    }

    function it_does_not_accept_a_non_string_or_empty_customer_phone()
    {
        $this->shouldThrow('InvalidArgumentException')->duringSetCustomerPhone(false);
        $this->shouldThrow('InvalidArgumentException')->duringSetCustomerPhone('');
    }

    function it_has_a_customer_email()
    {
        $this->getCustomerEmail()->shouldReturn('john.doe@domain.com');
    }

    function it_accepts_a_customer_email()
    {
        $this->setCustomerEmail('jane.doe@domain.com');

        $this->getCustomerEmail()->shouldReturn('jane.doe@domain.com');
    }

    function it_does_not_accept_a_non_email_customer_email()
    {
        $this->shouldThrow('InvalidArgumentException')->duringSetCustomerEmail('');
    }

    function it_has_a_description()
    {
        $this->getDescription()->shouldReturn(null);
    }

    function it_accepts_a_description()
    {
        $this->setDescription('description');

        $this->getDescription()->shouldReturn('description');
    }

    function it_does_not_accept_a_non_string_description()
    {
        $this->shouldThrow('InvalidArgumentException')->duringSetDescription(false);
    }

    function it_has_an_estimated_end(\DateTime $estimatedEnd)
    {
        $this->getEstimatedEnd()->shouldReturn($estimatedEnd);
    }

    function it_accepts_an_estimated_end(\DateTime $anotherEstimatedEnd)
    {
        $this->setEstimatedEnd($anotherEstimatedEnd);

        $this->getEstimatedEnd()->shouldReturn($anotherEstimatedEnd);
    }

    function it_has_a_creation_time()
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }
}
