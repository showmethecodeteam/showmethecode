<?php

namespace SMTC\MainBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Users
{
    /**
     * @Assert\Valid
     */
    public $users;

    public function __construct($users)
    {
        $this->users = $users;
    }
}
