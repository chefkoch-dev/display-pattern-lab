<?php

namespace Chefkoch\DisplayPatternLab\Model;

use KzykHys\FrontMatter\Document;
use Michelf\Markdown;
use KzykHys\FrontMatter\FrontMatter;

class MarkdownFile extends File
{

    /** @var Document */
    private $document;

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->getFrontMatterDocument()->getConfig();
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return Markdown::defaultTransform(
            $this->getFrontMatterDocument()->getContent()
        );
    }

    /**
     * @return Document
     */
    private function getFrontMatterDocument()
    {

        if (!$this->document) {
            $this->document = FrontMatter::parse($this->getContents());
        }

        return $this->document;
    }
}
