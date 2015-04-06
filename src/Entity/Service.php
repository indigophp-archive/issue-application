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

use Assert;
use Assert\Assertion;
use Doctrine\Common\Collections\ArrayCollection;
use Indigo\Doctrine\Entity\HasAuthor;
use Indigo\Doctrine\Field;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Service implements HasAuthor
{
    use Field\Id;
    use Field\Author;
    use Field\Description;

    /**
     * @var ArrayCollection
     */
    private $comments;

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
     * @param string    $customerName
     * @param string    $customerPhone
     * @param string    $customerEmail
     * @param \DateTime $estimatedEnd
     * @param string    $description
     */
    public function __construct(
        $customerName,
        $customerPhone,
        $customerEmail,
        \DateTime $estimatedEnd,
        $description = null
    ) {
        \Assert\lazy()
            ->that($customerName, 'customerName')->notEmpty()->string()
            ->that($customerPhone, 'customerPhone')->notEmpty()->string()
            ->that($customerEmail, 'customerEmail')->email()
            ->that($description, 'description')->nullOr()->string()
            ->verifyNow();

        $this->customerName = $customerName;
        $this->customerPhone = $customerPhone;
        $this->customerEmail = $customerEmail;
        $this->estimatedEnd = $estimatedEnd;
        $this->description = $description;

        $this->createdAt = new \DateTime('now');
        $this->comments = new ArrayCollection;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Returns the public comments
     *
     * @return ArrayCollection
     */
    public function getPublicComments()
    {
        return $this->comments->filter(function($comment) {
            return $comment->isInternal() === false;
        });
    }

    /**
     * Returns the internal comments
     *
     * @return ArrayCollection
     */
    public function getInternalComments()
    {
        return $this->comments->filter(function($comment) {
            return $comment->isInternal() === true;
        });
    }

    /**
     * Adds a comment
     *
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $comment->setService($this);

        $this->comments->add($comment);
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
        Assert\that($customerName)
            ->notEmpty()
            ->string();

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
        Assert\that($customerPhone)
            ->notEmpty()
            ->string();

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
        Assertion::email($customerEmail);

        $this->customerEmail = $customerEmail;
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
