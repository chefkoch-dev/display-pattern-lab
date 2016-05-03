<?php

namespace Chefkoch\DisplayPatternLab\Model;

class Pattern extends Node
{

    /**
     * @param Document[] $documents
     */
    public function fill(array $documents)
    {
        $variants = array();
        foreach ($documents as $document) {
            $variantName = preg_replace('(^' . preg_quote($this->getName() . '--') . ')', '', $document->getFilenameWithoutExtension());
            $variants[$variantName][] = $document;
        }

        foreach ($variants as $variantName => $childDocuments) {
            $variant = new Variant($variantName);
            $variant->fill($childDocuments);
            $this->addChild($variant);
        }
    }
}
