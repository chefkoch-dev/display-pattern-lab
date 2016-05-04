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
        return Yaml::parse($this->getContents());
    }
}
