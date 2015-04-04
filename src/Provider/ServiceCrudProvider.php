<?php

/*
 * This file is part of the Indigo Service application.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Service\Provider;

use Indigo\Service\Configuration\Service as ServiceConfiguration;
use Proton\Crud\CrudProvider;

/**
 * Provides Service CRUD
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ServiceCrudProvider extends CrudProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new ServiceConfiguration;
    }
}
