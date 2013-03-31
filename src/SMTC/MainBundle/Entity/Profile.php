<?php

namespace SMTC\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Fran Moreno <franmomu@gmail.com>
 */

/**
 * SMTC\MainBundle\Entity\Profile
 *
 * @ORM\Table(name="main_profile")
 * @ORM\Entity()
 */
class Profile
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\OneToOne(targetEntity="SMTC\MainBundle\Entity\User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param  $name
     * @return Profile
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return \username
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set user
     *
     * @param  \SMTC\MainBundle\Entity\User $user
     * @return User
     */
    public function setUser(\SMTC\MainBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SMTC\MainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
