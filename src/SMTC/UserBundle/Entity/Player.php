<?php

namespace SMTC\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;
use SMTC\UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Player extends User
{
    public function __construct()
    {
        parent::__construct();
        $this->addRole('ROLE_PLAYER');
    }
}
