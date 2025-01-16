<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $prenomAnimal = null;

    #[ORM\Column(length: 255)]
    private ?string $imgAnimal = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $curiositesAnimal = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionAnimal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenomAnimal(): ?string
    {
        return $this->prenomAnimal;
    }

    public function setPrenomAnimal(string $prenomAnimal): static
    {
        $this->prenomAnimal = $prenomAnimal;

        return $this;
    }

    public function getImgAnimal(): ?string
    {
        return $this->imgAnimal;
    }

    public function setImgAnimal(string $imgAnimal): static
    {
        $this->imgAnimal = $imgAnimal;

        return $this;
    }

    public function getCuriositesAnimal(): ?string
    {
        return $this->curiositesAnimal;
    }

    public function setCuriositesAnimal(string $curiositesAnimal): static
    {
        $this->curiositesAnimal = $curiositesAnimal;

        return $this;
    }

    public function getDescriptionAnimal(): ?string
    {
        return $this->descriptionAnimal;
    }

    public function setDescriptionAnimal(string $descriptionAnimal): static
    {
        $this->descriptionAnimal = $descriptionAnimal;

        return $this;
    }
}
