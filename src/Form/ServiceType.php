<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Service\Form;

use Fuel\Fieldset\Fieldset;
use Fuel\Fieldset\Form;
use Fuel\Fieldset\Input;
use Fuel\Validation\Validator;
use Proton\Crud\FormType;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ServiceType implements FormType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(Form $form)
    {
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
    }

    /**
     * {@inheritdoc}
     */
    public function buildValidation(Validator $validator)
    {
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
    }
}
