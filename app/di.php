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

return [
    'di' => [
        'Twig_Environment' => [
            'definition' => function($app, $paths, $extensions) {
                $config = $app->getConfig('twig', []);

                // always add the application as a path
                array_unshift($paths, $app->getConfig('path').'/views');

                $loader = new \Twig_Loader_Filesystem($paths);

                $twig = new \Twig_Environment($loader, $config);

                $twig->addGlobal('siteTitle', $app->getConfig('name'));
                $twig->addGlobal('baseUri', $app->getConfig('baseUri', '/'));
                $twig->addGlobal('baseUrl', $app->getConfig('baseUrl', ''));

                foreach ($extensions as $extension) {
                    $twig->addExtension($app[$extension]);
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
        'Knp\Menu\Matcher\MatcherInterface' => 'Knp\Menu\Matcher\Matcher',
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
                $config = Setup::createAnnotationMetadataConfiguration([APP_ROOT.'/src/Entity'], $app->getConfig('debug'));

                $conn = $app->getConfig('db');

                return EntityManager::create($conn, $config);
            },
            'arguments' => ['app'],
            'singleton' => true,
        ],
        'Indigo\Guardian\Identifier\LoginTokenIdentifier' => [
            'class' => 'Indigo\Guardian\Identifier\Doctrine',
            'arguments' => [
                'Doctrine\ORM\EntityManagerInterface',
                'very_ugly_workaround_hack',
            ],
            'methods' => [
                'setLoginTokenField' => ['id'],
            ],
        ],
        'Indigo\Guardian\Authenticator' => [
            'class'     => 'Indigo\Guardian\Authenticator\UserPassword',
            'arguments' => ['Indigo\Guardian\Hasher'],
        ],
        'Indigo\Guardian\Hasher' => 'Indigo\Guardian\Hasher\Plaintext',
        'Indigo\Guardian\Session' => 'Indigo\Guardian\Session\Native',
        'very_ugly_workaround_hack' => function() {
            return 'Indigo\Service\Entity\User';
        },
    ],
];
