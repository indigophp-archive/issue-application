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

use Indigo\Guardian\Caller\User as UserInterface;
use Indigo\Guardian\Caller\HasLoginToken;

/**
 * @Entity
 * @Table(name="users")
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class User implements UserInterface, HasLoginToken
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue
     *
     * @var integer
     */
    private $id;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    private $username;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    private $email;

    /**
     * @Column(type="string")
     *
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
     * Returns the ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
