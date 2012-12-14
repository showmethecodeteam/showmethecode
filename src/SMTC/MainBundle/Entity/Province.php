<?php

namespace SMTC\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Province entity
 *
 * @author Fran Moreno <franmomu@gmail.com>
 */

/**
 * SMTC\MainBundle\Entity\Province
 *
 * @ORM\Table(name="smtc_province")
 * @ORM\Entity(repositoryClass="SMTC\MainBundle\Entity\ProvinceRepository")
 */
class Province {

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
     * @ORM\ManyToOne(targetEntity="SMTC\MainBundle\Entity\Country", inversedBy="provinces")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    protected $country;

    /**
     * @ORM\OneToMany(targetEntity="SMTC\MainBundle\Entity\City", mappedBy="province")
     */
    protected $cities;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Province
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
     * @return Province
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
     * Set country
     *
     * @param \SMTC\MainBundle\Entity\Country $country
     * @return Province
     */
    public function setCountry(\SMTC\MainBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \SMTC\MainBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add cities
     *
     * @param \SMTC\MainBundle\Entity\City $cities
     * @return Province
     */
    public function addCitie(\SMTC\MainBundle\Entity\City $cities)
    {
        $this->cities[] = $cities;

        return $this;
    }

    /**
     * Remove cities
     *
     * @param \SMTC\MainBundle\Entity\City $cities
     */
    public function removeCitie(\SMTC\MainBundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities()
    {
        return $this->cities;
    }

    public function __toString()
    {
        return $this->name;
    }
}