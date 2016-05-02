<?php

namespace Chefkoch\DisplayPatternLab\Document;

use Michelf\Markdown;

class MarkdownFile extends Base
{

    /**
     * @return string
     */
    public function render()
    {
        return Markdown::defaultTransform($this->getFile()->getContents());
    }
}
