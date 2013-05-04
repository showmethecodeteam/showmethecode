<?php

namespace SMTC\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Fran Moreno <franmomu@gmail.com>
 */

/**
 * SMTC\MainBundle\Entity\Address
 *
 * @ORM\Table(name="main_address")
 * @ORM\Entity()
 */
class Address
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
     * @var string $street
     *
     * @ORM\Column(name="street", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $street;

    /**
     * @ORM\ManyToOne(targetEntity="SMTC\MainBundle\Entity\City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     * @Assert\Type("SMTC\MainBundle\Entity\City")
     * @Assert\NotNull()
     */
    protected $city;

    /**
     * @ORM\ManyToOne(targetEntity="SMTC\MainBundle\Entity\User", inversedBy="addresses")
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
     * Set street
     *
     * @param  string  $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param  \SMTC\MainBundle\Entity\City $city
     * @return Address
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

    /**
     * Set user
     *
     * @param  \SMTC\MainBundle\Entity\User $user
     * @return Address
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
