<?php

namespace Skyeff\FileSearchBundle\Util\SearchEngine;

class Registry {
    /** @var EngineInterface[] */
    private $engines;
    /** @var string */
    private $defaultEngineAlias;

    /**
     * Registry constructor.
     * @param $defaultEngineAlias
     */
    public function __construct($defaultEngineAlias) {
        $this->defaultEngineAlias = $defaultEngineAlias;
    }

    /**
     * @param EngineInterface $searchEngine
     * @param $alias
     */
    public function addSearchEngine(EngineInterface $searchEngine, $alias) {
        $this->engines[$alias] = $searchEngine;
    }

    /**
     * @param $alias
     * @return EngineInterface
     */
    public function getEngineOrDefault($alias) {
        return isset($this->engines[$alias]) ? $this->engines[$alias] : $this->getDefaultEngine();
    }

    /**
     * @return string
     */
    public function getDefaultEngineAlias() {
        return $this->defaultEngineAlias;
    }

    /**
     * @return EngineInterface
     */
    public function getDefaultEngine() {
        if (!isset($this->engines[$this->getDefaultEngineAlias()])) {
            throw new \RuntimeException('Default search engine is not configured.');
        }

        return $this->engines[$this->getDefaultEngineAlias()];
    }

    /**
     * @return array
     */
    public function getAliases() {
        return array_keys($this->engines);
    }
}