<?php

namespace App\Entity;

use App\Repository\RapportEmpRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportEmpRepository::class)]
class RapportEmp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $alimentationDonnee = null;

    #[ORM\Column(length: 255)]
    private ?string $quantiteDonnee = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlimentationDonnee(): ?string
    {
        return $this->alimentationDonnee;
    }

    public function setAlimentationDonnee(string $alimentationDonnee): static
    {
        $this->alimentationDonnee = $alimentationDonnee;

        return $this;
    }

    public function getQuantiteDonnee(): ?string
    {
        return $this->quantiteDonnee;
    }

    public function setQuantiteDonnee(string $quantiteDonnee): static
    {
        $this->quantiteDonnee = $quantiteDonnee;

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
}
