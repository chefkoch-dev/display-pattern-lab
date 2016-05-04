<?php

namespace Chefkoch\DisplayPatternLab\Model;

class Pattern extends AbstractNode
{

    /** @var Directory */
    private $directory;

    /** @var Variant[] */
    private $variants = array();

    /**
     * @param Directory $directory
     * @param $name
     */
    public function __construct(Directory $directory, $name)
    {
        parent::__construct($name);
        $this->directory = $directory;
    }

    public function getId()
    {
        return $this->directory->getId() . '-' . $this->getName();
    }

    /**
     * @return Variant[]
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @param File[] $file
     */
    public function addFile(File $file)
    {
        $variantName = preg_replace('(^' . preg_quote($this->getName() . '--') . ')', '', $file->getFilenameWithoutExtension());

        if (!($variant = @$this->variants[$variantName])) {
            $this->variants[$variantName] = $variant = new Variant($this, $variantName);
        }

        $variant->addFile($file);
    }
}
