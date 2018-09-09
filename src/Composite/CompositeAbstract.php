<?php

namespace App\Composite;

abstract class CompositeAbstract
{
    private $parent;
    private $children = [];

    public function addChild(CompositeAbstract $child)
    {
        $this->children[] = $child;
    }

    public function children() : array
    {
        return [];
    }

    public function hasChildren() : bool
    {
        return (bool)count($this->children);
    }

    public function getLastChild()
    {
        if(!$this->children) {
            return null;
        }
        return $this->children[count($this->children) - 1];
    }

    public function setParent(CompositeAbstract $parent)
    {
        $this->parent = $parent;
    }

    public function getParent() : ?CompositeAbstract
    {
        return $this->parent;
    }

    public function getLevel() : int
    {
        $level = 1;
        $parent = $this->getParent();
        while($parent) {
            $level++;
            $parent = $parent->getParent();
        }
        return $level;
    }

    public function deleteChild(string $uri)
    {
        foreach($this->children as $key => $child) {
            if($child->getUri() == $uri) {
                unset($this->children[$key]);
            }
        }
    }

    public function accept(CompositeVisitorInterface $visitor)
    {
        $visitor->visit($this);
    }
}
