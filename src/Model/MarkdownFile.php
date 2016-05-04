<?php

namespace Chefkoch\DisplayPatternLab\Model;

use Michelf\Markdown;

class MarkdownFile extends File
{

    /**
     * @return string
     */
    public function getHtml()
    {
        return Markdown::defaultTransform($this->getContents());
    }
}
