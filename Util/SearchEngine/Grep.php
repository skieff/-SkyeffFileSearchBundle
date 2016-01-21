<?php

namespace Skyeff\FileSearchBundle\Util\SearchEngine;

use Skyeff\FileSearchBundle\Entity\SearchTask;
use Symfony\Component\Process\Process;

class Grep implements EngineInterface {

    private $lookupDirList;
    /**
     * @var string
     */
    private $binary;

    public function __construct($lookupDirList, $binary) {
        $this->lookupDirList = (array)$lookupDirList;
        $this->binary = $binary;
    }


    /**
     * @param SearchTask $searchTask
     * @return array
     */
    public function findFiles2(SearchTask $searchTask)
    {
        // TODO: Implement findFiles2() method.

        return $this->findFiles($searchTask->getTerm());
    }

    /**
     * @param string $searchString
     * @return array
     */
    public function findFiles($searchString)
    {
        $result = [];

        foreach ($this->getLookupDirList() as $path) {
            $process = new Process(sprintf('%s -rnwils -e "%s" %s', $this->getBinary(), $searchString, $path));
            $process->run();

            $result = array_merge($result, array_filter(explode(PHP_EOL, $process->getOutput())));
        }

        return $result;
    }

    /**
     * @return array
     */
    private function getLookupDirList()
    {
        return $this->lookupDirList;
    }
    /**
     * @return string
     */
    private function getBinary()
    {
        return $this->binary;
    }
}