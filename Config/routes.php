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
        'controller' => 'Admin:Browser@indexAction'
    ),
    
    '/admin/module/team/page/(:var)' => array(
        'controller' => 'Admin:Browser@indexAction'
    ),
    
    '/admin/module/team/save.ajax' => array(
        'controller' => 'Admin:Browser@saveAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/team/delete.ajax' => array(
        'controller' => 'Admin:Browser@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/team/delete-selected.ajax' => array(
        'controller' => 'Admin:Browser@deleteSelectedAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/team/add' => array(
        'controller' => 'Admin:Add@indexAction'
    ),
    
    '/admin/module/team/add.ajax' => array(
        'controller' => 'Admin:Add@addAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/team/edit/(:var)' => array(
        'controller' => 'Admin:Edit@indexAction'
    ),
    
    '/admin/module/team/edit.ajax' => array(
        'controller' => 'Admin:Edit@updateAction',
        'disallow' => array('guest')
    ),
);
