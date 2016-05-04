<?php

namespace Chefkoch\DisplayPatternLab\Model;

class Directory extends AbstractFilesystemNode
{

    /** @var Directory */
    private $parentDirectory;

    /** @var Directory[] */
    private $subDirectories = array();

    /** @var MarkdownFile */
    private $documentation;

    /** @var Pattern[] */
    private $patterns;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->isRootDirectory() ? $this->getName() : $this->parentDirectory->getId() . '-' . $this->getName();
    }

    /**
     * @param Directory $directory
     */
    public function setParentDirectory(Directory $directory)
    {
        $this->parentDirectory = $directory;
    }

    /**
     * @param Directory $directory
     */
    public function addSubDirectory(Directory $directory)
    {
        $this->subDirectories[] = $directory;
        $directory->setParentDirectory($this);
    }

    /**
     * @return Directory[]
     */
    public function getSubDirectories()
    {
        return $this->subDirectories;
    }

    /**
     * @return Directory
     */
    public function getRootDirectory()
    {
        return $this->parentDirectory ? $this->parentDirectory->getRootDirectory() : $this;
    }

    /**
     * @return bool
     */
    public function isRootDirectory()
    {
        return $this->getRootDirectory() === $this;
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        if ($this->isRootDirectory()) {
            return 0;
        } else {
            return $this->parentDirectory->getDepth() + 1;
        }
    }

    /**
     * @param AbstractFilesystemNode[] $entries
     */
    public function addContent(AbstractFilesystemNode $content)
    {
        if ($content instanceof Directory) {

            $this->addSubDirectory($content);

        } elseif ($content instanceof File) {

            if ($content->getFile()->getFilename() == $this->getFile()->getFilename() . '.md') {
                $this->documentation = $content;
                return;
            }

            $fileNameWithoutExtension = $content->getFilenameWithoutExtension();
            $fileNameParts = explode('--', $fileNameWithoutExtension);
            $patternName = $fileNameParts[0];

            if (!($pattern = @$this->patterns[$patternName])) {
                $this->patterns[$patternName] = $pattern = new Pattern($this, $patternName);
            }

            $pattern->addFile($content);
        }
    }

    /**
     * @return MarkdownFile
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }

    /**
     * @return Pattern[]
     */
    public function getPatterns()
    {
        return $this->patterns;
    }
}
