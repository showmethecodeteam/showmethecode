<?php

namespace SMTC\MainBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Fish extends Animal
{
    /**
     * @Assert\NotBlank()
     * @Assert\Range(min=0)
     */
    public $finsNumber;
}
