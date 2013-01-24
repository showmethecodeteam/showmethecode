<?php

namespace SMTC\MainBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Location
{
    /**
     * @Assert\NotBlank()
     */
    public $address;

    /**
     * @Assert\Type("SMTC\MainBundle\Entity\City")
     * @Assert\NotNull()
     */
    public $city;
}
