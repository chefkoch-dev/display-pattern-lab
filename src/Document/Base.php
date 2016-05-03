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
     * @return int
     */
    public function getDepth()
    {
        $path = trim($this->file->getRelativePathname(), '/');
        if ($path === '') {
            return 0;
        } else {
            return count(explode('/', $path));
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return str_replace('/', '-', $this->file->getRelativePathname());
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->file->getRelativePathname();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->file->getFilename();
    }

    /**
     * @return string
     */
    public function getType()
    {
        $reflection = new \ReflectionClass($this);
        return strtolower($reflection->getShortName());
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->file->getContents();
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
}