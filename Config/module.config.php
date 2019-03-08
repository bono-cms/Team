<?php

/**
 * Module configuration container
 */

return array(
    'name' => 'Team',
    'description' => 'Team module allows to manage your personal',
    'menu' => array(
        'name' => 'Team',
        'icon' => 'fas fa-users',
        'items' => array(
            array(
                'route' => 'Team:Admin:Member@gridAction',
                'name' => 'View all members'
            ),
            array(
                'route' => 'Team:Admin:Member@addAction',
                'name' => 'Add a member'
            ),
            array(
                'route' => 'Team:Admin:Config@indexAction',
                'name' => 'Configuration'
            )
        )
    )
);