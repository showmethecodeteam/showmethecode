<?php

namespace SMTC\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Doctrine\Common\Collections\ArrayCollection;
use SMTC\UserBundle\Entity\Admin;
use SMTC\UserBundle\Entity\Player;

/**
 * @DoctrineAssert\UniqueEntity("email")
 *
 * @ORM\Entity
 * @ORM\Table(name="user_user")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *       "admin"    = "Admin",
 *       "player"   = "Player"
 *  })
 */

class User implements UserInterface, EquatableInterface, \Serializable
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\Length(min = 6)
     */
    private $password;

    /**
     * @var string $plainPassword
     *
     * @Assert\Length(min = 6)
     */
    private $plainPassword;

    /**
     * @var string $salt
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var array $roles
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\DateTime()
     */
    private $createdAt;


    public function __construct()
    {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->createdAt = new \DateTime();
    }


    public function serialize()
    {
       return serialize($this->getId());
    }

    public function unserialize($data)
    {
        $this->id = unserialize($data);
    }

    /**
     * Métodos requeridos por la interfaz EquatableInterface
     */

    public function isEqualTo(UserInterface $user)
    {
        return $this->getEmail() == $user->getEmail();
    }

    /**
     * Métodos requeridos por la interfaz UserInterface
     */

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
    }

    /**
     * Setters y Getters
     */

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Set roles
     *
     * @param  array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }


    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    public function removeRole($role)
    {
        $ind_role = array_search($role, $this->roles);
        if ($ind_role !== false) {
            unset($this->roles[$ind_role]);
        }
    }

    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
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
     * @param  string $name
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
     * Set email
     *
     * @param  string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

}