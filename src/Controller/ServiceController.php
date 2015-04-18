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
use Fuel\Fieldset\Fieldset;
use Fuel\Fieldset\Input;
use Fuel\Validation\Validator;
use Indigo\Service\Entity\Comment;
use Indigo\Service\Entity\Service;
use Knp\Snappy\Pdf;
use League\Route\Http\Exception\NotFoundException;
use Proton\Crud\Controller;
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
        'print'  => 'service/print.twig',
    ];

    /**
     * {@inheritdoc}
     */
    protected function createCreateForm()
    {
        $form = new Form;
        $form->setAttribute('method', 'POST');
        $form->setAttribute('action', $this->route);

        $customerFieldset = new Fieldset;
        $customerFieldset->setLegend(gettext('Customer details'));

        $customerFieldset['customerName'] = (new Input\Text('customerName'))
            ->setLabel(gettext('Customer name'));
        $customerFieldset['customerPhone'] = (new Input\Text('customerPhone'))
            ->setLabel(gettext('Customer phone'));
        $customerFieldset['customerEmail'] = (new Input\Email('customerEmail'))
            ->setLabel(gettext('Customer email'));

        $form['customerDetails'] = $customerFieldset;

        $serviceFieldset = new Fieldset;
        $serviceFieldset->setLegend(gettext('Service details'));

        $serviceFieldset['description'] = (new Input\Textarea('description'))
            ->setLabel(gettext('Description'));
        $serviceFieldset['estimatedEnd'] = (new Input\Text('estimatedEnd'))
            ->setLabel(gettext('Estimated end'));

        $form['serviceDetails'] = $serviceFieldset;

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

        $validator->addField('customerName', gettext('Customer name'))
            ->required();

        $validator->addField('customerPhone', gettext('Customer phone'))
            ->required();

        $validator->addField('customerEmail', gettext('Customer email'))
            ->required()
            ->email();

        $validator->addField('estimatedEnd', gettext('Estimated end'))
            ->required()
            ->date(['format' => 'Y-m-d']);

        $validator->addField('description', gettext('Description'));

        return $validator;
    }

    /**
     * {@inheritdoc}
     */
    protected function createEntity(array $data)
    {
        return new Service(
            $data['customerName'],
            $data['customerPhone'],
            $data['customerEmail'],
            new \DateTime($data['estimatedEnd']),
            $data['description']
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function loadData($entity)
    {
        return [
            'customerName' => $entity->getCustomerName(),
            'customerPhone' => $entity->getCustomerPhone(),
            'customerEmail' => $entity->getCustomerEmail(),
            'estimatedEnd' => $entity->getEstimatedEnd()->format('Y-m-d'),
            'description' => $entity->getDescription(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function createUpdateForm()
    {
        $form = $this->createCreateForm();
        $form->setAttribute('method', 'POST');

        $form['submit'] = (new Input\Button('submit'))
            ->setAttribute('type', 'submit')
            ->setContents(gettext('Update'));

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    protected function updateEntity($entity, array $data)
    {
        $entity->setCustomerName($data['customerName']);
        $entity->setCustomerPhone($data['customerPhone']);
        $entity->setCustomerEmail($data['customerEmail']);
        $entity->setEstimatedEnd(new \DateTime($data['estimatedEnd']));
        $entity->setDescription($data['description']);
    }

    /**
     * {@inheritdoc}
     */
    public function read(Request $request, Response $response, array $args)
    {
        $entity = $this->em->getRepository($this->entityClass)->find($args['id']);

        if ($entity) {
            $commentForm = $this->createCommentForm();
            $commentForm->setAttribute('action', $request->getRequestUri().'/comment');

            $response->setContent($this->twig->render($this->views['read'], [
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
        $form = new Form;

        $form['comment'] = (new Input\Textarea('comment'))
            ->setLabel(gettext('Comment'));

        $form['internal'] = (new Input\Checkbox('internal'))
            ->setLabel(gettext('Is internal?'));

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
    public function createComment(Request $request, Response $response, array $args)
    {
        $validator = $this->createCommentValidator();

        $rawData = $request->request->all();

        $result = $validator->run($rawData);

        if ($result->isValid()) {
            $comment = new Comment($rawData['comment'], isset($rawData['internal']) ? true : false);

            $entity = $this->em->getRepository($this->entityClass)->find($args['id']);

            $entity->addComment($comment);

            $this->em->flush();
        }

        return new RedirectResponse(sprintf('%s/%s', $this->route, $args['id']));
    }

    /**
     * Creates a new comment validation
     *
     * @return Validator
     */
    protected function createCommentValidator()
    {
        $validator = new Validator;

        $validator->addField('comment', gettext('Comment'))
            ->required();

        $validator->addField('internal', gettext('Is internal?'));

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
        $entity = $this->em->getRepository($this->entityClass)->find($args['id']);

        if ($entity) {
            $response->headers->set('Content-Type', 'application/pdf');
            // $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s.pdf"', $entity->getId()));

            $template = $this->twig->render($this->views['print'], [
                'entity' => $entity,
            ]);

            $pdf = new Pdf(getenv('WKHTMLTOPDF'));

            $response->setContent($pdf->getOutputFromHtml($template));

            return $response;
        }

        throw new NotFoundException;
    }
}
