<?php

namespace SMTC\MainBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Dog extends Animal
{
    /**
     * @Assert\NotBlank()
     */
    public $breed;
}
