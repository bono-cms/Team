<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Team\Storage;

interface TeamMapperInterface
{
    /**
     * Fetches a name by associated id
     * 
     * @param string $id Member's id
     * @return string
     */
    public function fetchNameById($id);

    /**
     * Updates an order by its associated id
     * 
     * @param string $id
     * @param string $order
     * @return boolean
     */
    public function updateOrderById($id, $order);

    /**
     * Update published state by its associated id
     * 
     * @param string $id
     * @param string $published Either 0 or 1
     * @return boolean
     */
    public function updatePublishedById($id, $published);

    /**
     * Fetch all members optionally filtered by pagination
     * 
     * @param boolean $published Whether to fetch only published
     * @param integer $page Page number
     * @param integer $itemsPerPage Per page count
     * @return \Krystal\Db\Sql\Db
     */
    public function fetchAll($published, $page, $itemsPerPage);

    /**
     * Fetches member data by their associated ID
     * 
     * @param string $id Member ID
     * @param boolean $withTranslations Whether to fetch translations or not
     * @return array
     */
    public function fetchById($id, $withTranslations);
}
