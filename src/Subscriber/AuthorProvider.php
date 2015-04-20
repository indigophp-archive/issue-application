<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Service\Subscriber;

use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Indigo\Service\Entity\HasAuthor;
use Indigo\Guardian\Service\Resume;

/**
 * Adds an author to the given entities
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class AuthorProvider implements EventSubscriber
{
    /**
     * @var Resume
     */
    protected $resumeService;

    /**
     * @param Resume $resumeService
     */
    public function __construct(Resume $resumeService)
    {
        $this->resumeService = $resumeService;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if ($entity instanceof HasAuthor and $entity->getAuthor() === null) {
            $author = $this->resumeService->getCurrentCaller();

            $entity->setAuthor($author);
        }
    }
}
