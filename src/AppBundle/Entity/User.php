<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     * @Assert\NotBlank(message="El nombre no puede estar vacío.")
     * @Assert\Length(min = 3,minMessage = "El nombre debe contener como mímino {{ limit }} caracteres."))
     * @Assert\Length(max = 100,maxMessage = "El nombre debe contener como máximo {{ limit }} caracteres."))
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     * @Assert\NotBlank(message="El correo no puede estar vacío.")
     * @Assert\Email(message="El correo es inválido.")
     * @Assert\Length(max = 100,maxMessage = "El correo debe contener como máximo {{ limit }} caracteres."))
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100)
     * @Assert\Length(max = 100,maxMessage = "La contraseña debe contener como mínimo {{ limit }} caracteres."))
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="user")
     */
    private $role;



    public function getRoles()
    {
        $roles[]= $this->role->getRole();

        return $roles;
    }

    public function getPassword()
    {
       return $this->password;
    }


    public function getUsername()
    {
        return $this->username;
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set role
     *
     * @param Role $role
     * @return User
     */
    public function setRole(Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }
}
