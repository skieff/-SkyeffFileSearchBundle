<?php

namespace Skyeff\FileSearchBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class SearchTask {
    /**
     * @var string
     */
    protected $engine = '';

    /**
     * @Assert\NotBlank()
     * @var string
     */
    protected $term = '';

    /**
     * @Assert\Range(min = 1, groups = {"resultsLimit"})
     * @var int
     */
    protected $limit = 50;

    /**
     * @var bool
     */
    protected $all = false;

    /**
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param string $engine
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;
    }

    /**
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return boolean
     */
    public function getAll()
    {
        return $this->all;
    }

    /**
     * @param boolean $all
     */
    public function setAll($all)
    {
        $this->all = $all;
    }

    /**
     * @param string $term
     */
    public function setTerm($term)
    {
        $this->term = $term;
    }
}