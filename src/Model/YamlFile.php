<?php

namespace Chefkoch\DisplayPatternLab\Model;

use Symfony\Component\Yaml\Yaml;

class YamlFile extends DataFile
{

    /**
     * @return array
     */
    public function getData()
    {
        return (array) Yaml::parse($this->getContents());
    }
}
