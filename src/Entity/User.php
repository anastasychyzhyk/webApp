<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $registrationDate;


    /**
     * @ORM\Column(type="string", length=12)
     */
    private $lastLoginDate;


    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
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
	
	 public function getStatus(): string
    {
        return $this->status;
    }
	
	public function setBlock(): self
    {
        $this->status = 'Block';
        return $this;
    }
	
	public function setActive(): self
    {
        $this->status = 'Active';
        return $this;
    }
	
	public function isActive()
	{
		return ($this->status=='Active');
	}
	
    public function getRegistrationDate(): string
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(string $registrationDate): self
    {
        $this->registrationDate = $registrationDate;
        return $this;
    }
	
	public function getLastLoginDate(): string
    {
        return $this->lastLoginDate;
    }

    public function setLastLoginDate(string $lastLoginDate): self
    {
        $this->lastLoginDate = $lastLoginDate;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
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
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {

    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {

    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}