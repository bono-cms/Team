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
    '/admin/module/team/config' => array(
        'controller' => 'Admin:Config@indexAction'
    ),
    
    '/admin/module/team/config.ajax' => array(
        'controller' => 'Admin:Config@saveAction',
        'disallow' => array('guest')
    ),
    
    '/module/team' => array(
        'controller' => 'Team@indexAction'
    ),
    
    '/admin/module/team' => array(
        'controller' => 'Admin:Member@gridAction'
    ),
    
    '/admin/module/team/page/(:var)' => array(
        'controller' => 'Admin:Member@gridAction'
    ),
    
    '/admin/module/team/tweak' => array(
        'controller' => 'Admin:Member@tweakAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/team/delete/(:var)' => array(
        'controller' => 'Admin:Member@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/team/add' => array(
        'controller' => 'Admin:Member@addAction'
    ),
    
    '/admin/module/team/edit/(:var)' => array(
        'controller' => 'Admin:Member@editAction'
    ),
    
    '/admin/module/team/save' => array(
        'controller' => 'Admin:Member@saveAction',
        'disallow' => array('guest')
    )
);
