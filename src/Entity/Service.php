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
     * @var \DateTime
     */
    private $estimatedEnd;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var integer
     */
    private $id;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     * @return Szerviz
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set customerPhone
     *
     * @param string $customerPhone
     * @return Szerviz
     */
    public function setCustomerPhone($customerPhone)
    {
        $this->customerPhone = $customerPhone;

        return $this;
    }

    /**
     * Get customerPhone
     *
     * @return string
     */
    public function getCustomerPhone()
    {
        return $this->customerPhone;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     * @return Szerviz
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * Get customerEmail
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Set estimatedEnd
     *
     * @param \DateTime $estimatedEnd
     * @return Szerviz
     */
    public function setEstimatedEnd($estimatedEnd)
    {
        $this->estimatedEnd = $estimatedEnd;

        return $this;
    }

    /**
     * Get estimatedEnd
     *
     * @return \DateTime
     */
    public function getEstimatedEnd()
    {
        return $this->estimatedEnd;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Szerviz
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
