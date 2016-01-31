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
        // Load view plugins
        $this->view->getPluginBag()
                   ->appendScript('@Team/admin/browser.js');

        // Append a breadcrumb
        $this->view->getBreadcrumbBag()
                   ->addOne('Team');

        $teamManager = $this->getTeamManager();

        $paginator = $teamManager->getPaginator();
        $paginator->setUrl('/admin/module/team/page/(:var)');

        return $this->view->render('browser', array(
            'members' => $teamManager->fetchAllByPage($page, $this->getSharedPerPageCount()),
            'paginator' => $paginator,
            'title' => 'Team'
        ));
    }

    /**
     * Removes selected team's member
     * 
     * @return string
     */
    public function deleteAction()
    {
        // Batch removal
        if ($this->request->hasPost('toDelete')) {
            $ids = array_keys($this->request->getPost('toDelete'));
            $this->getTeamManager()->deleteByIds($ids);

            $this->flashBag->set('success', 'Selected team member have been removed successfully');
        } else {
            $this->flashBag->set('warning', 'You should select at least one member to remove');
        }

        // Single removal
        if ($this->request->hasPost('id')) {
            $id = $this->request->getPost('id');

            if ($this->getTeamManager()->deleteById($id)) {
                $this->flashBag->set('success', 'Selected team member has been removed successfully');
            }
        }

        return '1';
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

        $formValidator = $this->validatorFactory->build(array(
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
        
        if ($formValidator->isValid()) {
            $teamManager = $this->getTeamManager();

            if ($input['id']) {
                if ($teamManager->update($this->request->getAll())) {
                    $this->flashBag->set('success', 'The member has been updated successfully');
                    return '1';
                }
                
            } else {
                if ($teamManager->add($this->request->getAll())) {
                    $this->flashBag->set('success', 'A member has been added successfully');
                    return $teamManager->getLastId();
                }
            }

        } else {
            return $formValidator->getErrors();
        }
    }
}
