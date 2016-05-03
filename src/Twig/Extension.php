<?php

namespace Chefkoch\DisplayPatternLab\Twig;

use Michelf\Markdown;
use Symfony\Component\Yaml\Yaml;

class Extension extends \Twig_Extension
{

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
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'markdown',
                array(Markdown::class, 'defaultTransform'),
                array(
                    'is_safe' => array('html')
                )
            ),
            new \Twig_SimpleFunction(
                'yamlize',
                function ($data) {
                    return Yaml::dump($data, 100);
                }
            )
        );
    }

}
