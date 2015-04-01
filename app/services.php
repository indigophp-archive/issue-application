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
            'definition' => function($app) {
                $config = $app->getConfig('twig', []);
                $paths = [];
                $options = [];

                if (isset($config['paths'])) {
                    foreach ($config['paths'] as $path) {
                        $paths[] = ROOTPATH.'/'.$path;
                    }
                }

                // always add the application as a path
                array_unshift($paths, $app->getConfig('path').'views');

                $loader = new \Twig_Loader_Filesystem($paths);

                if (isset($config['options'])) {
                    $options = $config['options'];
                }

                $twig = new \Twig_Environment($loader, $options);

                if (isset($config['extensions'])) {
                    foreach ($config['extensions'] as $extension) {
                        $twig->addExtension($app->getContainer()->get($extension));
                    }
                }

                return $twig;
            },
            'arguments' => ['app'],
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
        'Indigo\Fuel\Fieldset\RenderProvider' => [
            'class' => 'Indigo\Fuel\Fieldset\RenderProvider\SimpleProvider',
        ],
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
        ],
        'Indigo\Guardian\Authenticator' => [
            'class'     => 'Indigo\Guardian\Authenticator\UserPassword',
            'arguments' => ['hasher'],
        ],
        'hasher' => [
            'class' => 'Indigo\Guardian\Hasher\Plaintext',
        ],
        'Indigo\Guardian\Session' => [
            'class' => 'Indigo\Guardian\Session\Native'
        ],
        'Indigo\Guardian\Stack\Authentication' => [
            'class'     => 'Indigo\Guardian\Stack\Authentication',
            'arguments' => [
                'app',
                'Indigo\Guardian\Service\Resume',
                'Indigo\Guardian\Service\Logout',
            ],
        ],
        'Indigo\Hydra\Hydrator' => [
            'class' => 'Indigo\Hydra\Hydrator\Generated'
        ],
        'League\Tactician\CommandBus' => 'League\Tactician\CommandBus',
    ],
];
