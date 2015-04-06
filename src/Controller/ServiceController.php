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
use Indigo\Service\Entity\Comment;
use Indigo\Service\Form\ServiceType;
use Indigo\Service\Form\CommentType;
use Knp\Snappy\Pdf;
use League\Route\Http\Exception\NotFoundException;
use Proton\Crud\Command;
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
     * {@inheritdoc}
     */
    public function read(Request $request, Response $response, array $args)
    {
        $query = new Query\FindEntity($this->config, $args['id']);

        $entity = $this->commandBus->handle($query);

        if ($entity) {
            $commentForm = $this->createCommentForm();
            $commentForm->setAttribute('action', $request->getRequestUri().'/comment/create');

            $response->setContent($this->twig->render($this->config->getViewFor('read'), [
                'entity'      => $entity,
                'commentForm' => $commentForm,
            ]));

            return $response;
        }

        throw new NotFoundException;
    }

    /**
     * Creates a new comment form
     *
     * @return Form
     */
    protected function createCommentForm()
    {
        $commentType = new CommentType;
        $form = new Form;

        $commentType->buildForm($form);

        $form->setAttribute('method', 'POST');
        $form['submit'] = (new Input\Button('submit'))
            ->setAttribute('type', 'submit')
            ->setContents(gettext('Add comment'));

        return $form;
    }

    /**
     * Processes a new comment
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function processCreateComment(Request $request, Response $response, array $args)
    {
        $validator = $this->createCommentValidator();

        $rawData = $request->request->all();

        $result = $validator->run($rawData);

        if ($result->isValid()) {
            $comment = new Comment($rawData['comment'], isset($rawData['internal']) ? true : false);

            $query = new Query\FindEntity($this->config, $args['id']);

            $entity = $this->commandBus->handle($query);

            $entity->addComment($comment);

            $command = new Command\SaveEntity($this->config, $entity);

            $this->commandBus->handle($command);
        }

        return new RedirectResponse(sprintf('%s%s', $request->getBaseUrl(), $this->config->getRoute()));
    }

    /**
     * Creates a new comment validation
     *
     * @return Validator
     */
    protected function createCommentValidator()
    {
        $commentType = new CommentType;
        $validator = new Validator;

        $commentType->buildValidation($validator);

        return $validator;
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
