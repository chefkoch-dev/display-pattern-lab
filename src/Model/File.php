<?php

namespace Chefkoch\DisplayPatternLab\Model;

abstract class File extends AbstractFilesystemNode {

    /** @var Variant */
    private $variant;

    /**
     * @param Variant $variant
     */
    public function setVariant(Variant $variant)
    {
        $this->variant = $variant;
    }

    public function getId()
    {
        return $this->variant->getId() . '-' . $this->getName();
    }

    /**
     * @return string
     */
    public function getFilenameWithoutExtension()
    {
        return preg_replace('(.html.twig|.json|.md|.js|.scss|.yml|.yaml)', '', $this->getFile()->getFilename());
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->getFile()->getContents();
    }
}