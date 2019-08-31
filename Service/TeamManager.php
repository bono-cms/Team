<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Team\Service;

use Cms\Service\AbstractManager;
use Cms\Service\HistoryManagerInterface;
use Krystal\Image\Tool\ImageManagerInterface;
use Krystal\Security\Filter;
use Team\Storage\TeamMapperInterface;

final class TeamManager extends AbstractManager implements TeamManagerInterface
{
    /**
     * Any compliant team mapper
     * 
     * @var \Team\Storage\TeamMapperInterface
     */
    private $teamMapper;

    /**
     * Image manager to deal with images
     * 
     * @var \Krystal\Image\Tool\ImageManagerInterface
     */
    private $imageManager;

    /**
     * State initialization
     * 
     * @param \Team\Storage\TeamMapperInterface $teamMapper
     * @param \Krystal\Image\Tool\ImageManagerInterface $imageManager
     * @return void
     */
    public function __construct(TeamMapperInterface $teamMapper, ImageManagerInterface $imageManager)
    {
        $this->teamMapper = $teamMapper;
        $this->imageManager = $imageManager;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $member)
    {
        $imageBag = clone $this->imageManager->getImageBag();
        $imageBag->setId((int) $member['id'])
                 ->setCover($member['photo']);

        $entity = new TeamEntity();
        $entity->setImageBag($imageBag)
                  ->setId($member['id'], TeamEntity::FILTER_INT)
                  ->setLangId($member['lang_id'], TeamEntity::FILTER_INT)
                  ->setName($member['name'], TeamEntity::FILTER_HTML)
                  ->setDescription($member['description'], TeamEntity::FILTER_SAFE_TAGS)
                  ->setPhoto($member['photo'], TeamEntity::FILTER_HTML)
                  ->setPublished($member['published'], TeamEntity::FILTER_BOOL)
                  ->setOrder($member['order'], TeamEntity::FILTER_INT);

        return $entity;
    }

    /**
     * Returns prepared paginator's instance
     * 
     * @return \Krystal\Paginate\Paginator
     */
    public function getPaginator()
    {
        return $this->teamMapper->getPaginator();
    }

    /**
     * Fetches member's entity by associated id
     * 
     * @param string $id Member's id
     * @param boolean $withTranslations Whether to fetch translations or not
     * @return array
     */
    public function fetchById($id, $withTranslations)
    {
        if ($withTranslations == true) {
            return $this->prepareResults($this->teamMapper->fetchById($id, true));
        } else {
            return $this->prepareResult($this->teamMapper->fetchById($id, false));
        }
    }

    /**
     * Fetches all member entities filtered by pagination
     * 
     * @param boolean $published Whether to fetch published ones or not
     * @param integer $page
     * @param integer $itemsPerPage
     * @return array
     */
    public function fetchAll($published, $page, $itemsPerPage)
    {
        return $this->prepareResults($this->teamMapper->fetchAll($published, $page, $itemsPerPage));
    }

    /**
     * Returns last member id
     * 
     * @return integer
     */
    public function getLastId()
    {
        return $this->teamMapper->getLastId();
    }

    /**
     * Adds a member
     * 
     * @param array $input Raw input data
     * @return boolean
     */
    public function add(array $input)
    {
        // Ensure we have a file
        if (!empty($input['files'])) {
            $file =& $input['files']['file'];

            // A reference to form data
            $form =& $input['data']['team'];
            $translations =& $input['data']['translation'];

            // Append new photo key into data container
            $form['photo'] = $file->getUniqueName();

            // Safe type-casting
            $form['order'] = (int) $form['order'];

            // Insert must be first, so that we can get the last id
            return $this->teamMapper->saveEntity($form, $translations) && $this->imageManager->upload($this->getLastId(), $file);
        }
    }

    /**
     * Updates a member
     * 
     * @param array $input Raw input data
     * @return boolean Depending on success
     */
    public function update(array $input)
    {
        // Just a reference
        $form =& $input['data']['team'];
        $translations =& $input['data']['translation'];

        if (!empty($input['files'])) {
            $file =& $input['files']['file'];

            // When overriding a photo, we need to remove old one from the file-system
            if ($this->imageManager->delete($form['id'], $form['photo'])) {
                // Now upload a new one
                $form['photo'] = $file->getUniqueName();

                // Safe type-casting
                $form['order'] = (int) $form['order'];

                $this->imageManager->upload($form['id'], $file);
            } else {
                // Failed to remove old photo:
                return false;
            }
        }

        return $this->teamMapper->saveEntity($form, $translations);
    }

    /**
     * Removes a member by associated id
     * 
     * @param string $id Member id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->teamMapper->deleteEntity($id) && $this->imageManager->delete($id);
    }

    /**
     * Delete members by ids
     * 
     * @param array $ids
     * @return boolean
     */
    public function deleteByIds(array $ids)
    {
        foreach ($ids as $id) {
            if (!$this->deleteById($id)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Update settings
     * 
     * @param array $settings
     * @return boolean
     */
    public function updateSettings($settings)
    {
        return $this->teamMapper->updateSettings($settings);
    }
}
