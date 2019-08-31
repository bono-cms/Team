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

final class SiteService
{
    /**
     * Team manager service
     * 
     * @var \Team\Service\TeamManager
     */
    private $teamManager;

    /**
     * State initialization
     * 
     * @param \Team\Service\TeamManager $teamManager
     * @return void
     */
    public function __construct(TeamManager $teamManager)
    {
        $this->teamManager = $teamManager;
    }

    /**
     * Returns all member entities
     * 
     * @return array
     */
    public function getAll()
    {
        return $this->teamManager->fetchAll(true, null, null);
    }
}
