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

use Fuel\Fieldset\Form;
use Fuel\Fieldset\Input;
use Fuel\Validation\Validator;
use Proton\Crud\FormType;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CommentType implements FormType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(Form $form)
    {
        $form['comment'] = (new Input\Textarea('comment'))
            ->setLabel(gettext('Comment'));

        $form['internal'] = (new Input\Checkbox('internal'))
            ->setLabel(gettext('Is internal?'));
    }

    /**
     * {@inheritdoc}
     */
    public function buildValidation(Validator $validator)
    {
        $validator->addField('comment', gettext('Comment'))
            ->required();

        $validator->addField('internal', gettext('Is internal?'));
    }
}
