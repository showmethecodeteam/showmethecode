<?php

namespace SMTC\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of City
 *
 * @author Fran Moreno <franmomu@gmail.com>
 */

/**
 * SMTC\MainBundle\Entity\City
 *
 * @ORM\Table(name="smtc_city")
 * @ORM\Entity(repositoryClass="SMTC\MainBundle\Entity\CityRepository")
 */
class City {
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
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity="SMTC\MainBundle\Entity\Province", inversedBy="cities")
     * @ORM\JoinColumn(name="province_id", referencedColumnName="id")
     */
    protected $province;

    /**
     * @ORM\OneToMany(targetEntity="SMTC\MainBundle\Entity\User", mappedBy="city")
     */
    protected $people;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->people = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return City
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
     * Set slug
     *
     * @param string $slug
     * @return City
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set province
     *
     * @param \SMTC\MainBundle\Entity\Province $province
     * @return City
     */
    public function setProvince(\SMTC\MainBundle\Entity\Province $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \SMTC\MainBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Add people
     *
     * @param \SMTC\MainBundle\Entity\User $people
     * @return City
     */
    public function addPeople(\SMTC\MainBundle\Entity\User $people)
    {
        $this->people[] = $people;

        return $this;
    }

    /**
     * Remove people
     *
     * @param \SMTC\MainBundle\Entity\User $people
     */
    public function removePeople(\SMTC\MainBundle\Entity\User $people)
    {
        $this->people->removeElement($people);
    }

    /**
     * Get people
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPeople()
    {
        return $this->people;
    }

    public function __toString()
    {
        return $this->name;
    }
}