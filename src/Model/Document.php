<?php

namespace Chefkoch\DisplayPatternLab\Model;

use Symfony\Component\Finder\SplFileInfo;

abstract class Document extends Node {

    /** @var SplFileInfo */
    private $file;

    /**
     * Base constructor.
     * @param SplFileInfo $file
     */
    public function __construct(SplFileInfo $file)
    {
        parent::__construct($file->getFilename());
        $this->file = $file;
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
    public function getFilenameWithoutExtension()
    {
        return preg_replace('(.html.twig|.json|.md|.js|.scss|.yml|.yaml)', '', $this->file->getFilename());
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->file->getContents();
    }

    /**
     * @return SplFileInfo
     */
    public function getFile()
    {
        return $this->file;
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
}