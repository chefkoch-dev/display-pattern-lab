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
     * @return Variant|null
     */
    public function getMainVariant()
    {
        return @$this->variants[''];
    }

    /**
     * @return Variant[]
     */
    public function getOtherVariants()
    {
        return array_filter(
            $this->getVariants(),
            function (Variant $variant) {
                return !$variant->isMainVariant();
            }
        );
    }

    /**
     * @param File[] $file
     */
    public function addFile(File $file)
    {
        $variantName = Pattern::extractVariantName($file);

        if (!($variant = @$this->variants[$variantName])) {
            $this->variants[$variantName] = $variant = new Variant($this, $variantName);
        }

        $variant->addFile($file);
    }

    /**
     * @return bool
     */
    public function hasTemplate()
    {
        foreach ($this->getVariants() as $variant) {
            if ($variant->getTwigfile()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param File $file
     * @return string
     */
    public static function extractPatternName(File $file)
    {
        return self::extractNameParts($file)[0];
    }

    /**
     * @param File $file
     * @return string
     */
    public static function extractVariantName(File $file)
    {
        $nameParts = self::extractNameParts($file);
        array_shift($nameParts);
        return implode('--', $nameParts);
    }

    /**
     * @param File $file
     * @return array
     */
    private static function extractNameParts(File $file)
    {
        $fileNameWithoutExtension = $file->getFilenameWithoutExtension();
        return explode('--', $fileNameWithoutExtension);
    }
}
