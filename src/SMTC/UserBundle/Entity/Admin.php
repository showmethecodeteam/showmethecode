<?php

namespace SMTC\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SMTC\UserBundle\Entity\User;

/**
 * @ORM\Entity
 */
class Admin extends User
{
    public function __construct()
    {
        parent::__construct();
        $this->addRole('ROLE_ADMIN');
    }
}