<?php

namespace Chefkoch\DisplayPatternLab\Document;

use Symfony\Component\Finder\SplFileInfo;

abstract class Base {

    /** @var SplFileInfo */
    private $file;

    /** @var Base */
    private $parent = null;

    /** @var Base[] */
    private $childDocuments = array();

    /**
     * Base constructor.
     * @param SplFileInfo $file
     */
    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
    }

    /**
     * @param Base $parent
     */
    public function setParent(Base $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * @param Base $document
     */
    public function addChildDocument(Base $document)
    {
        $this->childDocuments[] = $document;
        $document->setParent($this);
    }

    /**
     * @return Base
     */
    public function getRoot()
    {
        return $this->parent ? $this->parent->getRoot() : $this;
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        return $this->getRoot() === $this;
    }

    /**
     * @return Base[]
     */
    public function getChildDocuments()
    {
        return $this->childDocuments;
    }

    /**
     * @return SplFileInfo
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    abstract function render();
}