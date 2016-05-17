<?php

namespace Chefkoch\DisplayPatternLab\Model;

class JsonFile extends DataFile
{

    /**
     * @return array
     */
    public function getData()
    {
        return (array) json_decode($this->getContents(), true);
    }
}
