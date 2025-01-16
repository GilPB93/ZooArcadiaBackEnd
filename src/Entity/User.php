<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 128)]
    private ?string $nomUser = null;

    #[ORM\Column(length: 128)]
    private ?string $prenomUser = null;

    #[ORM\Column(length: 255)]
    private ?string $apiToken = null;

    /** @throws RandomException */
    public function __construct()
    {
        $this->apiToken = bin2hex(random_bytes(20));
    }


    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToOne(mappedBy: 'createdBy', cascade: ['persist', 'remove'])]
    private ?RapportEmp $rapportEmp = null;

    #[ORM\OneToOne(mappedBy: 'createdBy', cascade: ['persist', 'remove'])]
    private ?RapportVet $rapportVet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Add a role to the user.
     */
    public function addRole(string $role): static
    {
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles, true);
    }

    /**
     * Remove a role from the user.
     */
    public function removeRole(string $role): static
    {
        $this->roles = array_filter(
            $this->roles,
            fn($existingRole) => $existingRole !== $role
        );

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): static
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenomUser;
    }

    public function setPrenomUser(string $prenomUser): static
    {
        $this->prenomUser = $prenomUser;

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(string $apiToken): static
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRapportEmp(): ?RapportEmp
    {
        return $this->rapportEmp;
    }

    public function setRapportEmp(RapportEmp $rapportEmp): static
    {
        // set the owning side of the relation if necessary
        if ($rapportEmp->getCreatedBy() !== $this) {
            $rapportEmp->setCreatedBy($this);
        }

        $this->rapportEmp = $rapportEmp;

        return $this;
    }

    public function getRapportVet(): ?RapportVet
    {
        return $this->rapportVet;
    }

    public function setRapportVet(RapportVet $rapportVet): static
    {
        // set the owning side of the relation if necessary
        if ($rapportVet->getCreatedBy() !== $this) {
            $rapportVet->setCreatedBy($this);
        }

        $this->rapportVet = $rapportVet;

        return $this;
    }
}
