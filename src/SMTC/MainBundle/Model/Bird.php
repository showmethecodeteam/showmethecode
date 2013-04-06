<?php

namespace SMTC\MainBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Bird extends Animal
{
    /**
     * @Assert\Type(type="bool")
     */
    public $canFly;
}
