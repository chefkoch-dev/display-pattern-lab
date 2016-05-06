<?php

namespace Chefkoch\DisplayPatternLab\Model;

use Symfony\Component\Yaml\Yaml;

class Variant extends AbstractNode
{

    /** @var Pattern */
    private $pattern;

    /** @var TwigFile */
    private $twigfile;

    /** @var ScssFile */
    private $scssFile;

    /** @var MarkdownFile */
    private $documentation;

    /** @var DataFile[] */
    private $dataFiles = array();

    /**
     * @param Pattern $pattern
     * @param $name
     */
    public function __construct(Pattern $pattern, $name)
    {
        parent::__construct($name);
        $this->pattern = $pattern;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->pattern->getId() . '-' . $this->getName();
    }

    /**
     * @param File[] $file
     */
    public function addFile(File $file)
    {
        $file->setVariant($this);

        if ($file instanceof TwigFile) {
            $this->twigfile = $file;
        } elseif ($file instanceof DataFile) {
            $this->dataFiles[] = $file;
        } elseif ($file instanceof ScssFile) {
            $this->scssFile = $file;
        } elseif ($file instanceof MarkdownFile) {
            $this->documentation = $file;
        }
    }

    /**
     * @return bool
     */
    public function isMainVariant()
    {
        return $this->getName() == '';
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (!$this->isMainVariant() && ($mainVariant = $this->pattern->getMainVariant())) {
            $data = $mainVariant->getData();
        } else {
            $data = array();
        }
        foreach ($this->dataFiles as $file) {
            $data = array_merge($data, $file->getData());
        }

        return $data;
    }
    
    /**
     * @return TwigFile
     */
    public function getTwigfile()
    {
        return $this->twigfile;
    }

    /**
     * @return ScssFile
     */
    public function getScssFile()
    {
        return $this->scssFile;
    }

    /**
     * @return MarkdownFile
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }
}
