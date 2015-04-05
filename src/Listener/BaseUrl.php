<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Service\Listener;

use League\Container\ContainerInterface;
use League\Event\AbstractListener;
use League\Event\EventInterface;

/**
 * Registers the base URL with the Twig instance
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class BaseUrl extends AbstractListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(EventInterface $event, $request = null)
    {
        $twig = $this->container->get('Twig_Environment');

        $twig->addGlobal('baseUrl', $request->getScheme().'://'.$request->getHttpHost().$request->getBaseUrl());
        // $twig->addGlobal('baseUrl', $request->getBaseUrl());
    }
}
