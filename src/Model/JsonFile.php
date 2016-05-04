<?php

namespace Chefkoch\DisplayPatternLab\Model;

class JsonFile extends DataFile
{

    /**
     * @return array
     */
    public function getData()
    {
        return json_decode($this->getContents(), true);
    }
}
