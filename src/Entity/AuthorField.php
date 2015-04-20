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
trait AuthorField
{
    /**
     * @ManyToOne(targetEntity="Indigo\Service\Entity\User", inversedBy="author")
     *
     * @var User
     */
    private $author;

    /**
     * {@inheritdoc}
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }
}
