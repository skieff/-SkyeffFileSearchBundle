<?php

namespace Skyeff\FileSearchBundle\Tests\Util\SearchEngine;

use Skyeff\FileSearchBundle\Entity\SearchTask;
use Skyeff\FileSearchBundle\Util\SearchEngine\EngineInterface;

class FakeEngine implements EngineInterface {

    /**
     * @param SearchTask $searchTask
     * @return array
     */
    public function findFiles2(SearchTask $searchTask)
    {
        return ['../match.1'];
    }
}