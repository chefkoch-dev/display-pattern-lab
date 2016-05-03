<?php

namespace Chefkoch\DisplayPatternLab\Model;

class Variant extends Node
{

    /**
     * @param array $documents
     */
    public function fill(array $documents)
    {
        foreach ($documents as $document) {
            $this->addChild($document);
        }
    }
}
