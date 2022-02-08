<?php

namespace App\Domain\Auth\Entity;

use App\Domain\Auth\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $username = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $registerAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lastLogin = null;

    #[ORM\Column(type: Types::STRING, nullable:  true)]
    private ?string $lastLoginIP = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::STRING)]
    private string $password;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $confirmation_token = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return User
     */
    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return User
     */
    public function setUsername(?string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getRegisterAt(): \DateTimeInterface
    {
        return $this->registerAt;
    }

    /**
     * @param \DateTimeInterface $registerAt
     * @return User
     */
    public function setRegisterAt(\DateTimeInterface $registerAt): User
    {
        $this->registerAt = $registerAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getLastLogin(): \DateTimeInterface
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTimeInterface $lastLogin
     * @return User
     */
    public function setLastLogin(\DateTimeInterface $lastLogin): User
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastLoginIP(): string
    {
        return $this->lastLoginIP;
    }

    /**
     * @param string $lastLoginIP
     * @return User
     */
    public function setLastLoginIP(string $lastLoginIP): User
    {
        $this->lastLoginIP = $lastLoginIP;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface $updatedAt
     * @return User
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): User
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }


    public function eraseCredentials(): array
    {
        return []; // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @return array|string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array|string[] $roles
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getConfirmationToken(): ?string
    {
        return $this->confirmation_token;
    }

    /**
     * @param string|null $confirmation_token
     * @return User
     */
    public function setConfirmationToken(?string $confirmation_token): User
    {
        $this->confirmation_token = $confirmation_token;
        return $this;
    }
}
