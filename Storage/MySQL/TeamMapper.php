<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Team\Storage\MySQL;

use Cms\Storage\MySQL\AbstractMapper;
use Team\Storage\TeamMapperInterface;
use Krystal\Db\Sql\RawSqlFragment;

final class TeamMapper extends AbstractMapper implements TeamMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getTableName()
    {
        return self::getWithPrefix('bono_module_team');
    }

    /**
     * {@inheritDoc}
     */
    public static function getTranslationTable()
    {
        return TeamTranslationMapper::getTableName();
    }

    /**
     * Returns shared columns
     * 
     * @return array
     */
    private function getColumns()
    {
        return array(
            self::getFullColumnName('id'),
            self::getFullColumnName('order'),
            self::getFullColumnName('photo'),
            self::getFullColumnName('published'),
            TeamTranslationMapper::getFullColumnName('lang_id'),
            TeamTranslationMapper::getFullColumnName('name'),
            TeamTranslationMapper::getFullColumnName('description'),
        );
    }

    /**
     * Fetches a name by associated id
     * 
     * @param string $id Member's id
     * @return string
     */
    public function fetchNameById($id)
    {
        return $this->findColumnByPk($id, 'name');
    }

    /**
     * Updates an order by its associated id
     * 
     * @param string $id
     * @param string $order
     * @return boolean
     */
    public function updateOrderById($id, $order)
    {
        return $this->updateColumnByPk($id, 'order', $order);
    }

    /**
     * Update published state by its associated id
     * 
     * @param string $id
     * @param string $published Either 0 or 1
     * @return boolean
     */
    public function updatePublishedById($id, $published)
    {
        return $this->updateColumnByPk($id, 'published', $published);
    }

    /**
     * Returns shared select query
     * 
     * @param boolean $published
     * @return \Krystal\Db\Sql\Db
     */
    private function getSelectQuery($published)
    {
        // Build first fragment
        $db = $this->createEntitySelect($this->getColumns())
                   ->whereEquals(TeamTranslationMapper::getFullColumnName('lang_id'), $this->getLangId());

        if ($published === true) {
            $db->andWhereEquals(self::getFullColumnName('published'), '1')
               ->orderBy(new RawSqlFragment('`order`, CASE WHEN `order` = 0 THEN `id` END DESC'));
        } else {
            $db->orderBy(self::getFullColumnName('id'))
               ->desc();
        }

        return $db;
    }

    /**
     * Fetches all published records
     * 
     * @param integer $page
     * @param integer $itemsPerPage
     * @return array
     */
    public function fetchAllPublishedByPage($page, $itemsPerPage)
    {
        return $this->getSelectQuery(true)
                    ->paginate($page, $itemsPerPage)
                    ->queryAll();
    }

    /**
     * Fetches all records
     * 
     * @return array
     */
    public function fetchAll()
    {
        return $this->getSelectQuery(false)
                    ->queryAll();
    }

    /**
     * Fetches all published records
     * 
     * @return array
     */
    public function fetchAllPublished()
    {
        return $this->getSelectQuery(true)
                    ->queryAll();
    }

    /**
     * Fetches all members filtered by pagination
     * 
     * @param integer $page
     * @param integer $itemsPerPage
     * @return array
     */
    public function fetchAllByPage($page, $itemsPerPage)
    {
        return $this->getSelectQuery(false)
                    ->paginate($page, $itemsPerPage)
                    ->queryAll();
    }

    /**
     * Fetches member data by their associated ID
     * 
     * @param string $id Member ID
     * @param boolean $withTranslations Whether to fetch translations or not
     * @return array
     */
    public function fetchById($id, $withTranslations)
    {
        return $this->findEntity($this->getColumns(), $id, $withTranslations);
    }
}
