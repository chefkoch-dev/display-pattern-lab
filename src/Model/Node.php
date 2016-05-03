<?php

namespace Chefkoch\DisplayPatternLab\Model;

abstract class Node
{

    /** @var Node */
    private $parent;

    /** @var Node[] */
    private $nodes = array();

    /**
     * @return string
     */
    public function getType()
    {
        $reflection = new \ReflectionClass($this);
        return strtolower($reflection->getShortName());
    }

    /**
     * @param Node $node
     */
    public function setParent(Node $node)
    {
        $this->parent = $node;
    }

    /**
     * @param Node $node
     * @param null $name
     */
    public function addChild(Node $node, $name = null)
    {
        if ($name) {
            $this->nodes[$name] = $node;
        } else {
            $this->nodes[] = $node;
        }
        $node->setParent($this);
    }

    /**
     * @return Node[]
     */
    public function getChildren()
    {
        return $this->nodes;
    }

    /**
     * @param $name
     * @return Node
     */
    public function getChild($name)
    {
        return @$this->nodes[$name];
    }

    /**
     * @return Node
     */
    public function getRoot()
    {
        return $this->parent ? $this->parent->getRoot() : $this;
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        return $this->getRoot() === $this;
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        if ($this->isRoot()) {
            return 0;
        } else {
            return $this->parent->getDepth() + 1;
        }
    }
}
