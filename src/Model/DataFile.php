<?php

namespace Chefkoch\DisplayPatternLab\Model;

abstract class DataFile extends File
{

    /**
     * @return array
     */
    abstract public function getData();
}
