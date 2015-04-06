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

use Indigo\Doctrine\Entity\Author;
use Indigo\Doctrine\Field;
use Indigo\Guardian\Caller\User as UserInterface;
use Indigo\Guardian\Caller\HasLoginToken;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class User implements Author, UserInterface, HasLoginToken
{
    use Field\Id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct($username, $email, $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function getLoginToken()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Returns the email address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }
}
