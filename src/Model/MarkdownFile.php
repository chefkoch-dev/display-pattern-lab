<?php

namespace Chefkoch\DisplayPatternLab\Model;

use Michelf\Markdown;
use KzykHys\FrontMatter\FrontMatter;

class MarkdownFile extends File
{

    /**
     * @return string
     */
    public function getHtml()
    {
        $document = FrontMatter::parse($this->getContents());

        $markup = '';
        if ($document->getConfig()) {
            $markup .= $GLOBALS['twig']->render(
                '@lab/content/_frontmatter.html.twig',
                [ 'frontmatter' => $document->getConfig() ]
            );
        }

        $markup .= Markdown::defaultTransform($document->getContent());
        return $markup;
    }
}
