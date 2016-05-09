<?php

namespace Chefkoch\DisplayPatternLab\Twig;

use Symfony\Component\Yaml\Yaml;

class Extension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{

    /** @var string */
    private $cssFile;

    /**
     * @param string $cssFile
     */
    public function __construct($cssFile)
    {
        $this->cssFile = $cssFile;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'display-pattern-lab';
    }

    /**
     * @return array
     */
    public function getGlobals()
    {
        return array(
            'displayPatternsCss' => $this->cssFile
        );
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter(
                'dump',
                function ($string, $inline = 1, $indent = 2) {
                    return Yaml::dump($string, $inline, $indent);
                },
                ['is_safe' => ['html']]
            )
        );
    }
}
