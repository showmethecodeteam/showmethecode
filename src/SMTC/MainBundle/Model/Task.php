<?php

namespace SMTC\MainBundle\Model;

class Task
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function render()
    {
        return sprintf('Task: %s', $this->name);
    }
}
