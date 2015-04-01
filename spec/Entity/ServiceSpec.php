<?php

namespace spec\Indigo\Service\Entity;

use PhpSpec\ObjectBehavior;

class ServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Service\Entity\Service');
    }

    function it_has_an_id()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_a_customer_name()
    {
        $this->setCustomerName('Customer');

        $this->getCustomerName()->shouldReturn('Customer');
    }

    function it_has_a_customer_phone()
    {
        $this->setCustomerPhone('+36-(12)-345-6789');

        $this->getCustomerPhone()->shouldReturn('+36-(12)-345-6789');
    }

    function it_has_a_customer_email()
    {
        $this->setCustomerEmail('test@domain.com');

        $this->getCustomerEmail()->shouldReturn('test@domain.com');
    }

    function it_has_a_public_comment()
    {
        $this->setPublicComment('Public comment');

        $this->getPublicComment()->shouldReturn('Public comment');
    }

    function it_has_a_internal_comment()
    {
        $this->setInternalComment('Internal comment');

        $this->getInternalComment()->shouldReturn('Internal comment');
    }

    function it_has_an_estimated_end()
    {
        $estimatedEnd = new \DateTime('now');

        $this->setEstimatedEnd($estimatedEnd);

        $this->getEstimatedEnd()->shouldReturn($estimatedEnd);
    }

    function it_has_a_creation_time()
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }
}
