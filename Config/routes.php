<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

return array(
    '/%s/module/team/config' => array(
        'controller' => 'Admin:Config@indexAction'
    ),
    
    '/%s/module/team/config.ajax' => array(
        'controller' => 'Admin:Config@saveAction',
        'disallow' => array('guest')
    ),
    
    '/module/team' => array(
        'controller' => 'Team@indexAction'
    ),
    
    '/%s/module/team' => array(
        'controller' => 'Admin:Member@gridAction'
    ),
    
    '/%s/module/team/page/(:var)' => array(
        'controller' => 'Admin:Member@gridAction'
    ),
    
    '/%s/module/team/tweak' => array(
        'controller' => 'Admin:Member@tweakAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/team/delete/(:var)' => array(
        'controller' => 'Admin:Member@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/team/add' => array(
        'controller' => 'Admin:Member@addAction'
    ),
    
    '/%s/module/team/edit/(:var)' => array(
        'controller' => 'Admin:Member@editAction'
    ),
    
    '/%s/module/team/save' => array(
        'controller' => 'Admin:Member@saveAction',
        'disallow' => array('guest')
    )
);
