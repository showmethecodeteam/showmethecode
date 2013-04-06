<?php

namespace SMTC\MainBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

abstract class Animal
{
    /**
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @Assert\Range(min=0)
     * @Assert\NotBlank()
     */
    public $age;

    /**
     * @Assert\Range(min=0)
     * @Assert\NotBlank()
     */
    public $weight;
}
