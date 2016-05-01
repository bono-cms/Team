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

use Cms\Controller\Admin\AbstractController;
use Krystal\Validate\Pattern;
use Krystal\Stdlib\VirtualEntity;

final class Member extends AbstractController
{
    /**
     * Returns team manager
     * 
     * @return \Team\Service\TeamManager
     */
    private function getTeamManager()
    {
        return $this->getModuleService('teamManager');
    }

    /**
     * Creates a form
     * 
     * @param \Krystal\Stdlib\VirtualEntity $member
     * @param string $title
     * @return string
     */
    private function createForm(VirtualEntity $member, $title)
    {
        // Load view plugins
        $this->view->getPluginBag()
                   ->appendScript('@Team/admin/member.form.js')
                   ->load(array($this->getWysiwygPluginName(), 'preview'));

        // Append breadcrumbs
        $this->view->getBreadcrumbBag()->addOne('Team', 'Team:Admin:Member@gridAction')
                                       ->addOne($title);

        return $this->view->render('member.form', array(
            'member' => $member
        ));
    }

    /**
     * Renders empty form
     * 
     * @return string
     */
    public function addAction()
    {
        $member = new VirtualEntity();
        $member->setPublished(true);

        return $this->createForm($member, 'Add a member');
    }

    /**
     * Renders edit form
     * 
     * @param string $id
     * @return string
     */
    public function editAction($id)
    {
        $member = $this->getTeamManager()->fetchById($id);

        if ($member !== false) {
            return $this->createForm($member, 'Edit the member');
        } else {
            return false;
        }
    }

    /**
     * Renders a grid
     * 
     * @param integer $page Current page
     * @return string
     */
    public function gridAction($page = 1)
    {
        // Append a breadcrumb
        $this->view->getBreadcrumbBag()
                   ->addOne('Team');

        $teamManager = $this->getTeamManager();

        $paginator = $teamManager->getPaginator();
        $paginator->setUrl($this->createUrl('Team:Admin:Member@gridAction', array(), 1));

        return $this->view->render('browser', array(
            'members' => $teamManager->fetchAllByPage($page, $this->getSharedPerPageCount()),
            'paginator' => $paginator,
            'title' => 'Team'
        ));
    }

    /**
     * Removes selected team's member
     * 
     * @param string $id
     * @return string
     */
    public function deleteAction($id)
    {
        return $this->invokeRemoval('teamManager', $id);
    }

    /**
     * Save changes
     * 
     * @return string
     */
    public function tweakAction()
    {
        if ($this->request->hasPost('published', 'order')) {
            $published = $this->request->getPost('published');
            $orders = $this->request->getPost('order');

            $teamManager = $this->getTeamManager();
            $teamManager->updateOrders($orders);
            $teamManager->updatePublished($published);

            $this->flashBag->set('success', 'Settings have been updated successfully');
            return '1';
        }
    }

    /**
     * Persists a member
     * 
     * @return string
     */
    public function saveAction()
    {
        $input = $this->request->getPost('team');

        return $this->invokeSave('teamManager', $input['id'], $this->request->getAll(), array(
            'input' => array(
                'source' => $input,
                'definition' => array(
                    'name' => new Pattern\Name(),
                    'description' => new Pattern\Description()
                )
            ),
            'file' => array(
                'source' => $this->request->getFiles(),
                'definition' => array(
                    'file' => new Pattern\ImageFile(array(
                        'required' => !$input['id']
                    ))
                )
            )
        ));
    }
}
