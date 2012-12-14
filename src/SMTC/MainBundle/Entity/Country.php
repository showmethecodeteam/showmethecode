<?php

namespace SMTC\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country entity
 *
 * @author Fran Moreno <franmomu@gmail.com>
 */

/**
 * SMTC\MainBundle\Entity\Country
 *
 * @ORM\Table(name="smtc_country")
 * @ORM\Entity(repositoryClass="SMTC\MainBundle\Entity\CountryRepository")
 */
class Country {

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
     * @ORM\OneToMany(targetEntity="SMTC\MainBundle\Entity\Province", mappedBy="country")
     */
    protected $provinces;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->provinces = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Country
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
     * @return Country
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
     * Add provinces
     *
     * @param \SMTC\MainBundle\Entity\Province $provinces
     * @return Country
     */
    public function addProvince(\SMTC\MainBundle\Entity\Province $provinces)
    {
        $this->provinces[] = $provinces;

        return $this;
    }

    /**
     * Remove provinces
     *
     * @param \SMTC\MainBundle\Entity\Province $provinces
     */
    public function removeProvince(\SMTC\MainBundle\Entity\Province $provinces)
    {
        $this->provinces->removeElement($provinces);
    }

    /**
     * Get provinces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProvinces()
    {
        return $this->provinces;
    }

    public function __toString()
    {
        return $this->name;
    }
}