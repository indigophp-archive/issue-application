<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Service\Entity;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Service
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $customerName;

    /**
     * @var string
     */
    private $customerPhone;

    /**
     * @var string
     */
    private $customerEmail;

    /**
     * @var string
     */
    private $publicComment;

    /**
     * @var string
     */
    private $internalComment;

    /**
     * @var \DateTime
     */
    private $estimatedEnd;

    /**
     * @var \DateTime
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    /**
     * Returns the id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the customer name
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Sets the customer name
     *
     * @param string $customerName
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
    }

    /**
     * Returns the customer phone
     *
     * @return string
     */
    public function getCustomerPhone()
    {
        return $this->customerPhone;
    }

    /**
     * Sets the customer phone
     *
     * @param string $customerPhone
     */
    public function setCustomerPhone($customerPhone)
    {
        $this->customerPhone = $customerPhone;
    }

    /**
     * Returns the customer email
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Sets the customer email
     *
     * @param string $customerEmail
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;
    }

    /**
     * Returns the public comment
     *
     * @return string
     */
    public function getPublicComment()
    {
        return $this->publicComment;
    }

    /**
     * Sets the public comment
     *
     * @param string $publicComment
     */
    public function setPublicComment($publicComment)
    {
        $this->publicComment = $publicComment;
    }

    /**
     * Returns the internal comment
     *
     * @return string
     */
    public function getInternalComment()
    {
        return $this->internalComment;
    }

    /**
     * Sets the internal comment
     *
     * @param string $internalComment
     */
    public function setInternalComment($internalComment)
    {
        $this->internalComment = $internalComment;
    }

    /**
     * Returns the estimated end
     *
     * @return \DateTime
     */
    public function getEstimatedEnd()
    {
        return $this->estimatedEnd;
    }

    /**
     * Sets the estimated end
     *
     * @param \DateTime $estimatedEnd
     */
    public function setEstimatedEnd(\DateTime $estimatedEnd)
    {
        $this->estimatedEnd = $estimatedEnd;
    }

    /**
     * Returns when the service was created at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
