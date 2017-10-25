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
     * Fetches all published records
     * 
     * @param integer $page
     * @param integer $itemsPerPage
     * @return array
     */
    public function fetchAllPublishedByPage($page, $itemsPerPage);

    /**
     * Fetches all records
     * 
     * @return array
     */
    public function fetchAll();

    /**
     * Fetches all published records
     * 
     * @return array
     */
    public function fetchAllPublished();

    /**
     * Fetches all members filtered by pagination
     * 
     * @param integer $page
     * @param integer $itemsPerPage
     * @return array
     */
    public function fetchAllByPage($page, $itemsPerPage);

    /**
     * Fetches member data by their associated ID
     * 
     * @param string $id Member ID
     * @param boolean $withTranslations Whether to fetch translations or not
     * @return array
     */
    public function fetchById($id, $withTranslations);
}
