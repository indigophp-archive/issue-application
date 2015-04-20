<?php

/*
 * This file is part of the Indigo Doctrine Extension package.
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
interface HasAuthor
{
    /**
     * Returns the author (if any)
     *
     * If it is an association, the value is set at persist
     *
     * @return User
     */
    public function getAuthor();

    /**
     * Sets the author
     *
     * @param User $author
     */
    public function setAuthor(User $author);
}
