<?php

namespace  Skyeff\FileSearchBundle\Util\SearchEngine;

use Skyeff\FileSearchBundle\Entity\SearchTask;

interface EngineInterface {

    /**
     * @param SearchTask $searchTask
     * @return array
     */
    public function findFiles2(SearchTask $searchTask);
}