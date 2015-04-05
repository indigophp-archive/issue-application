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
use Knp\Snappy\Pdf;
use League\Route\Http\Exception\NotFoundException;
use Proton\Crud\Controller;
use Proton\Crud\Query;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles Service CRUD logic
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ServiceController extends Controller
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    protected function createValidator()
    {
        $validator = new Validator;
        $formType = new ServiceType;

        $formType->buildValidation($validator);

        return $validator;
    }

    /**
     * {@inheritdoc}
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
     * Prints the service into PDF
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function pdf(Request $request, Response $response, array $args)
    {
        $query = new Query\FindEntity($this->config, $args['id']);

        $entity = $this->commandBus->handle($query);

        if ($entity) {
            $response->headers->set('Content-Type', 'application/pdf');
            // $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s.pdf"', $entity->getId()));

            $template = $this->twig->render($this->config->getViewFor('print'), [
                'entity' => $entity,
            ]);

            $pdf = new Pdf(getenv('WKHTMLTOPDF'));

            $response->setContent($pdf->getOutputFromHtml($template));

            return $response;
        }

        throw new NotFoundException;
    }
}
