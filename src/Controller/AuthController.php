<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Service\Controller;

use Indigo\Guardian\Service\Login;
use Proton\Tools\AuthController as ParentController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Login handling controller
 *
 * @author Márk Sági-Kazár <webmaster@firstcomputer.hu>
 */
class AuthController extends ParentController
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @param \Twig_Environment $twig
     * @param Login             $loginService
     */
    public function __construct(\Twig_Environment $twig, Login $loginService)
    {
        $this->twig = $twig;

        parent::__construct($loginService);
    }

    /**
     * {@inheritdoc}
     */
    public function login(Request $request, Response $response, array $args)
    {
        $response->setContent($this->twig->render('login.twig', [
            'loginUri' => $request->getRequestUri(),
        ]));

        return $response;
    }
}
