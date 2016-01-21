<?php

namespace Skyeff\FileSearchBundle\Util\SearchEngine;

use Skyeff\FileSearchBundle\Entity\SearchTask;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class Basic implements EngineInterface{
    private $maxAllowedFileSize;
    private $lookupDirList;

    public function __construct($lookupDirList, $maxAllowedFileSize) {
        $this->maxAllowedFileSize = $maxAllowedFileSize;
        $this->lookupDirList = (array)$lookupDirList;
    }

    /**
     * @param SearchTask $searchTask
     * @return array
     */
    public function findFiles2(SearchTask $searchTask)
    {
        return $this->findFiles($searchTask->getTerm());
    }

    /**
     * @param string $searchString
     * @return array
     */
    public function findFiles($searchString) {
        $lookupDirList = $this->getLookupDirList();

        if (empty($searchString) || empty($lookupDirList)) {
            return [];
        }

        $result = [];

        foreach($this->createIterator($lookupDirList) as $fileInfo) {
            /** @var \SplFileInfo $fileInfo */

            if ($this->match($fileInfo, $searchString)) {
                $result[] = $fileInfo->getPathname();
            }
        }

        return $result;
    }

    /**
     * @param \SplFileInfo $fileInfo
     * @return bool
     */
    protected function canProceed(\SplFileInfo $fileInfo)
    {
        return $fileInfo->isFile() && $fileInfo->isReadable() && $this->isAllowedFileSize($fileInfo);
    }

    /**
     * @param \SplFileInfo $fileInfo
     * @return bool
     */
    protected function isAllowedFileSize(\SplFileInfo $fileInfo)
    {
        return $fileInfo->getSize() > 0 && $fileInfo->getSize() <= $this->getMaxAllowedFileSize();
    }

    /**
     * @return int
     */
    protected function getMaxAllowedFileSize()
    {
        return $this->maxAllowedFileSize;
    }

    /**
     * @return array
     */
    protected function getLookupDirList()
    {
        return $this->lookupDirList;
    }

    /**
     * @param array $lookupDirList
     * @return \RecursiveDirectoryIterator|\RecursiveIteratorIterator
     */
    protected function createIterator(array $lookupDirList)
    {
        $result = new \AppendIterator();

        foreach($lookupDirList as $path) {
            $result->append(new \RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS, true)
            ));
        }

        return $result;
    }

    /**
     * @param \SplFileInfo $fileInfo
     * @param $searchString
     * @return bool
     */
    protected function match(\SplFileInfo $fileInfo, $searchString)
    {
        if ($this->canProceed($fileInfo)) {
            $fileObject = $fileInfo->openFile('r');
            $content = $fileObject->fread($fileInfo->getSize());

            if (false !== $content) {
                if (stristr($content, $searchString)) {
                    return true;
                }
            }
        }

        return false;
    }
}