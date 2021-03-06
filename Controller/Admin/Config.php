<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Team\Controller\Admin;

use Cms\Controller\Admin\AbstractConfigController;
use Krystal\Validate\Pattern;

final class Config extends AbstractConfigController
{
    /**
     * {@inheritDoc}
     */
    protected $parent = 'Team:Admin:Member@gridAction';

    /**
     * {@inheritDoc}
     */
    protected function getValidationRules()
    {
        return array(
            'per_page_count' => new Pattern\PerPageCount(),
            'cover_height' => new Pattern\ThumbHeight(),
            'cover_width' => new Pattern\ThumbWidth()
        );
    }
}
