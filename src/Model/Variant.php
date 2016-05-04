<?php

namespace Chefkoch\DisplayPatternLab\Model;

class Variant extends AbstractNode
{

    /** @var Pattern */
    private $pattern;

    /** @var TwigFile */
    private $twigfile;

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
        }
    }

    /**
     * @return TwigFile
     */
    public function getTwigfile()
    {
        return $this->twigfile;
    }
}
