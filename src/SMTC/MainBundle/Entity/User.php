<?php

namespace SMTC\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Fran Moreno <franmomu@gmail.com>
 */

/**
 * SMTC\MainBundle\Entity\User
 *
 * @ORM\Table(name="main_user")
 * @ORM\Entity()
 */
class User
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
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @ORM\OneToOne(targetEntity="SMTC\MainBundle\Entity\Profile", mappedBy="user", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    protected $profile;

    /**
     * @ORM\OneToMany(targetEntity="SMTC\MainBundle\Entity\Address", mappedBy="user", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    protected $addresses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->profile ? $this->profile->getName() : $this->username;
    }

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
     * Set username
     *
     * @param  $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return \username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set profile
     *
     * @param  \SMTC\MainBundle\Entity\Profile $profile
     * @return User
     */
    public function setProfile(\SMTC\MainBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;
        $profile->setUser($this);

        return $this;
    }

    /**
     * Get profile
     *
     * @return \SMTC\MainBundle\Entity\Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * set addresses
     *
     * @return \SMTC\MainBundle\Entity\Profile
     */
    public function setAddresses(\Doctrine\Common\Collections\Collection $addresses)
    {
        $this->addresses = $addresses;
        foreach ($addresses as $address) {
            $address->setUser($this);
        }
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
}
