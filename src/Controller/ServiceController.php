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

use Fuel\Fieldset\Form;
use Fuel\Fieldset\Input;
use Fuel\Validation\Validator;
use Indigo\Service\Form\ServiceType;
use League\Route\Http\Exception\NotFoundException;
use Proton\Crud\Controller;
use Proton\Crud\Query;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Handles Service CRUD logic
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ServiceController extends Controller
{
    /**
     * @var string
     */
    protected $entityClass = 'Indigo\Service\Entity\Service';

    /**
     * @var string
     */
    protected $route = '/services';

    /**
     * @var array
     */
    protected $views = [
        'create' => 'service/create.twig',
        'read'   => 'service/read.twig',
        'update' => 'service/update.twig',
        'list'   => 'service/list.twig',
    ];

    /**
     * CREATE form
     *
     * @return Form
     */
    protected function createCreateForm()
    {
        $form = new Form;
        $form->setAttribute('method', 'POST');

        $formType = new ServiceType;
        $formType->buildForm($form);

        $form['submit'] = (new Input\Button('submit'))
            ->setAttribute('type', 'submit')
            ->setContents(gettext('Create'));

        return $form;
    }

    /**
     * Creates validation
     *
     * @return Validator
     */
    protected function createValidator()
    {
        $validator = new Validator;
        $formType = new ServiceType;

        $formType->buildValidation($validator);

        return $validator;
    }

    /**
     * UPDATE form
     *
     * @return Form
     */
    protected function createUpdateForm()
    {
        $form = new Form;
        $form->setAttribute('method', 'POST');

        $formType = new ServiceType;
        $formType->buildForm($form);

        $form['submit'] = (new Input\Button('submit'))
            ->setAttribute('type', 'submit')
            ->setContents(gettext('Update'));

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function index(Request $request, Response $response, array $args)
    {
        $query = new Query\FindAllEntities($this->entityClass);

        $entities = $this->commandBus->handle($query);

        $response->setContent($this->twig->render('service/list.twig', [
            'entities' => $entities
        ]));

        return $response;
    }
}
