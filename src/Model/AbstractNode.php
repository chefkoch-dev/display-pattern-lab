<?php

namespace Chefkoch\DisplayPatternLab\Model;

abstract class AbstractNode
{

    /** @var string */
    private $name;

    /**
     * Node constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    abstract function getId();

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        $reflection = new \ReflectionClass($this);

        return strtolower($reflection->getShortName());
    }
}
