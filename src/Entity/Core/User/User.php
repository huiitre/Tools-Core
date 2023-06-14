<?php

namespace App\Entity\Core\User;

use App\Repository\Core\User\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $iduser;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $is_active;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string
     */
    private $nickname;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Get the value of is_active
     *
     * @return  integer
     */ 
    public function getIs_active()
    {
        return $this->is_active;
    }

    /**
     * Set the value of is_active
     *
     * @param  integer  $is_active
     *
     * @return  self
     */ 
    public function setIs_active($is_active)
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * Get the value of nickname
     *
     * @return  string
     */ 
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set the value of nickname
     *
     * @param  string  $nickname
     *
     * @return  self
     */ 
    public function setNickname(string $nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get the value of type
     *
     * @return  integer
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param  integer  $type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
