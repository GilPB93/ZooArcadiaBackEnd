<?php

namespace App\Entity;

use App\Repository\ZooAvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZooAvisRepository::class)]
class ZooAvis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $avisName = null;

    #[ORM\Column(length: 255)]
    private ?string $avisEmail = null;

    #[ORM\Column(length: 255)]
    private ?string $avisTitre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $avisMessage = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvisName(): ?string
    {
        return $this->avisName;
    }

    public function setAvisName(string $avisName): static
    {
        $this->avisName = $avisName;

        return $this;
    }

    public function getAvisEmail(): ?string
    {
        return $this->avisEmail;
    }

    public function setAvisEmail(string $avisEmail): static
    {
        $this->avisEmail = $avisEmail;

        return $this;
    }

    public function getAvisTitre(): ?string
    {
        return $this->avisTitre;
    }

    public function setAvisTitre(string $avisTitre): static
    {
        $this->avisTitre = $avisTitre;

        return $this;
    }

    public function getAvisMessage(): ?string
    {
        return $this->avisMessage;
    }

    public function setAvisMessage(string $avisMessage): static
    {
        $this->avisMessage = $avisMessage;

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
