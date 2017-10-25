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

interface TeamManagerInterface
{
    /**
     * Returns prepared paginator's instance
     * 
     * @return \Krystal\Paginate\Paginator
     */
    public function getPaginator();

    /**
     * Fetches all member entities filtered by pagination
     * 
     * @param boolean $published Whether to fetch published ones or not
     * @param integer $page
     * @param integer $itemsPerPage
     * @return array
     */
    public function fetchAll($published, $page, $itemsPerPage);

    /**
     * Returns last member id
     * 
     * @return integer
     */
    public function getLastId();

    /**
     * Adds a member
     * 
     * @param array $input Raw input data
     * @return boolean
     */
    public function add(array $input);

    /**
     * Updates a member
     * 
     * @param array $input Raw input data
     * @return boolean Depending on success
     */
    public function update(array $input);

    /**
     * Fetches member's entity by associated id
     * 
     * @param string $id Member's id
     * @param boolean $withTranslations Whether to fetch translations or not
     * @return array
     */
    public function fetchById($id, $withTranslations);

    /**
     * Removes a member by associated id
     * 
     * @param string $id Member id
     * @return boolean
     */
    public function deleteById($id);

    /**
     * Delete members by ids
     * 
     * @param array $ids
     * @return boolean
     */
    public function deleteByIds(array $ids);

    /**
     * Update settings
     * 
     * @param array $settings
     * @return boolean
     */
    public function updateSettings($settings);
}
