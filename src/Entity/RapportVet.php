<?php

namespace App\Entity;

use App\Enum\etatHabitat;
use App\Repository\RapportVetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportVetRepository::class)]
class RapportVet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $etatSante = null;

    #[ORM\Column(length: 255)]
    private ?string $alimentationRecommendee = null;

    #[ORM\Column(length: 255)]
    private ?string $quantiteRecommendee = null;

    #[ORM\Column(enumType: etatHabitat::class)]
    private ?etatHabitat $etatHabitat = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentHabitat = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtatSante(): ?string
    {
        return $this->etatSante;
    }

    public function setEtatSante(string $etatSante): static
    {
        $this->etatSante = $etatSante;

        return $this;
    }

    public function getAlimentationRecommendee(): ?string
    {
        return $this->alimentationRecommendee;
    }

    public function setAlimentationRecommendee(string $alimentationRecommendee): static
    {
        $this->alimentationRecommendee = $alimentationRecommendee;

        return $this;
    }

    public function getQuantiteRecommendee(): ?string
    {
        return $this->quantiteRecommendee;
    }

    public function setQuantiteRecommendee(string $quantiteRecommendee): static
    {
        $this->quantiteRecommendee = $quantiteRecommendee;

        return $this;
    }

    public function getEtatHabitat(): ?etatHabitat
    {
        return $this->etatHabitat;
    }

    public function setEtatHabitat(etatHabitat $etatHabitat): static
    {
        $this->etatHabitat = $etatHabitat;

        return $this;
    }

    public function getCommentHabitat(): ?string
    {
        return $this->commentHabitat;
    }

    public function setCommentHabitat(string $commentHabitat): static
    {
        $this->commentHabitat = $commentHabitat;

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