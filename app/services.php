<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Indigo\Guardian\Service\Resume;
use Indigo\Service\Provider\ServiceCrudProvider;
use Indigo\Service\Subscriber\AuthorProvider;
use Proton\Crud\CrudServiceProvider;

return [
    'di' => [
        new CrudServiceProvider,
        'service.crud_provider' => new ServiceCrudProvider,
        'Twig_Environment' => [
            'definition' => function($app, $paths, $extensions) {
                $config = $app->getConfig('twig', []);

                // always add the application as a path
                array_unshift($paths, $app->getConfig('path').'/views');

                $loader = new \Twig_Loader_Filesystem($paths);

                $twig = new \Twig_Environment($loader, $config);

                $twig->addGlobal('siteTitle', $app->getConfig('name', 'Application'));

                foreach ($extensions as $extension) {
                    $twig->addExtension($app->getContainer()->get($extension));
                }

                return $twig;
            },
            'arguments' => [
                'app',
                [
                    APP_ROOT.'/vendor/knplabs/knp-menu/src/Knp/Menu/Resources/views',
                    APP_ROOT.'/vendor/indigophp/proton-crud/views',
                ],
                [
                    'Knp\Menu\Twig\MenuExtension',
                    'Indigo\Fuel\Fieldset\Twig\FieldsetExtension',
                ],
            ],
            'singleton' => true,
        ],
        'Knp\Menu\Provider\MenuProviderInterface' => [
            'class'     => 'Indigo\KnpMenu\Provider\LeagueContainerProvider',
            'arguments' =>[
                'League\Container\Container',
                [
                    'main' => 'menu.main',
                ],
            ],
        ],
        'Knp\Menu\Renderer\RendererProviderInterface' => [
            'class'     => 'Indigo\KnpMenu\Renderer\LeagueContainerProvider',
            'arguments' =>[
                'League\Container\Container',
                'main',
                [
                    'main' => 'Knp\Menu\Renderer\RendererInterface',
                ],
            ],
        ],
        'Knp\Menu\Renderer\RendererInterface' => [
            'class'     => 'Knp\Menu\Renderer\TwigRenderer',
            'arguments' => [
                'Twig_Environment',
                'knp_menu.html.twig',
                'Knp\Menu\Matcher\MatcherInterface',
            ],
        ],
        'Knp\Menu\Matcher\MatcherInterface' => [
            'class'     => 'Knp\Menu\Matcher\Matcher',
            'methods' => [
                'addVoter' => ['menu_uri_voter'],
            ],
        ],
        'menu_uri_voter' => [
            'definition' => function($request) {
                return new \Knp\Menu\Matcher\Voter\UriVoter($request->getPathInfo());
            },
            'arguments'  => ['Symfony\Component\HttpFoundation\Request'],
        ],
        'menu.main' => [
            'definition' => function($factory) {
                $menu = $factory->createItem('Main menu');

                $menu->addChild('home', [
                    'uri'   => '/',
                    'label' => gettext('Home'),
                ])
                ->setLinkAttribute('title', gettext('Home'));

                $menu->addChild('services', [
                    'uri'   => '/services',
                    'label' => gettext('Service'),
                ])
                ->setLinkAttribute('title', gettext('Service'));

                $menu->addChild('logout', [
                    'uri'   => '/logout',
                    'label' => gettext('Logout'),
                ])
                ->setLinkAttribute('title', gettext('Logout'));

                return $menu;
            },
            'singleton' => true,
            'arguments' => ['Knp\Menu\MenuFactory'],
        ],
        'Indigo\Fuel\Fieldset\RenderProvider' => 'Indigo\Fuel\Fieldset\RenderProvider\SimpleProvider',
        'Doctrine\ORM\EntityManagerInterface' => [
            'definition' => function($app) {
                $config = Setup::createConfiguration($app->getConfig('debug'));
                $driver = new SimplifiedXmlDriver([
                    __DIR__.'/orm/' => 'Indigo\Service\Entity'
                ]);
                $config->setMetadataDriverImpl($driver);

                $conn = $app->getConfig('db');

                return EntityManager::create($conn, $config);
            },
            'arguments' => ['app'],
            'singleton' => true,
        ],
        'Indigo\Guardian\Identifier\LoginTokenIdentifier' => [
            'definition' => function($em) {
                $identifier = new \Indigo\Guardian\Identifier\Doctrine($em, 'Indigo\Service\Entity\User');

                $identifier->setLoginTokenField('id');

                return $identifier;
            },
            'arguments' => [
                'Doctrine\ORM\EntityManagerInterface',
            ],
            'singleton' => true,
        ],
        'Indigo\Guardian\Authenticator' => [
            'class'     => 'Indigo\Guardian\Authenticator\UserPassword',
            'arguments' => ['hasher'],
        ],
        'hasher' => 'Indigo\Guardian\Hasher\Plaintext',
        'Indigo\Guardian\Session' => 'Indigo\Guardian\Session\Native',
        'Indigo\Guardian\Service\Resume' => [
            'definition' => function($identifier, $session, $em) {
                $service = new Resume($identifier, $session);

                $authorProvider = new AuthorProvider($service);
                $em->getEventManager()->addEventSubscriber($authorProvider);

                return $service;
            },
            'arguments' => [
                'Indigo\Guardian\Identifier\LoginTokenIdentifier',
                'Indigo\Guardian\Session',
                'Doctrine\ORM\EntityManagerInterface',
            ],
        ],
        'Indigo\Guardian\Stack\Authentication' => [
            'class'     => 'Indigo\Guardian\Stack\Authentication',
            'arguments' => [
                'app',
                'Indigo\Guardian\Service\Resume',
                'Indigo\Guardian\Service\Logout',
            ],
        ],
        'Indigo\Hydra\Hydrator' => 'Indigo\Hydra\Hydrator\Generated',
    ],
];
