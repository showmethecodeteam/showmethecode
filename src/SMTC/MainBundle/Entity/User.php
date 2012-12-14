<?php

namespace SMTC\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author Fran Moreno <franmomu@gmail.com>
 */

/**
 * SMTC\MainBundle\Entity\User
 *
 * @ORM\Table(name="smtc_user")
 * @ORM\Entity(repositoryClass="SMTC\MainBundle\Entity\UserRepository")
 */
class User {
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
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="SMTC\MainBundle\Entity\City", inversedBy="people")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;


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
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set city
     *
     * @param \SMTC\MainBundle\Entity\City $city
     * @return User
     */
    public function setCity(\SMTC\MainBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \SMTC\MainBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    public function __toString()
    {
        return $this->name;
    }
}