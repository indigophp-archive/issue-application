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

/**
 * @Entity
 * @Table(name="service_comments")
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Comment implements HasAuthor
{
    use AuthorField;

    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue
     *
     * @var integer
     */
    private $id;

    /**
     * @Column(type="text", nullable=true)
     *
     * @var string
     */
    private $comment;

    /**
     * @Column(type="boolean", options={"default":false})
     *
     * @var boolean
     */
    private $internal = false;

    /**
     * @Column(type="datetime")
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ManyToOne(targetEntity="Indigo\Service\Entity\Service")
     *
     * @var Service
     */
    private $service;

    /**
     * @param string  $comment
     * @param boolean $internal
     */
    public function __construct($comment, $internal = false)
    {
        Assert\lazy()
            ->that($comment, 'comment')->notEmpty()->string()
            ->that($internal, 'internal')->boolean()
            ->verifyNow();

        $this->comment = $comment;
        $this->internal = $internal;
        $this->createdAt = new \DateTime('now');
    }

    /**
     * Returns the ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Sets the comment
     *
     * @param string $comment
     */
    public function setComment($comment)
    {
        Assert\that($comment)
            ->notEmpty()
            ->string();

        $this->comment = $comment;
    }

    /**
     * Checks if the comment is internal
     *
     * @return string
     */
    public function isInternal()
    {
        return $this->internal;
    }

    /**
     * Sets the internal state
     *
     * @param string $internal
     */
    public function setInternal($internal)
    {
        Assertion::boolean($internal);

        $this->internal = $internal;
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

    /**
     * Returns the service (if any, set by persisting the entity)
     *
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Sets the service
     *
     * @param Service $service
     */
    public function setService(Service $service)
    {
        $this->service = $service;
    }
}
