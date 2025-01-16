<?php

namespace App\Entity;

use App\Repository\HabitatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitatRepository::class)]
class Habitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $habitatName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $habitatDescription = null;

    #[ORM\Column(length: 255)]
    private ?string $habitatImg = null;

    #[ORM\OneToOne(mappedBy: 'habitat', cascade: ['persist', 'remove'])]
    private ?Animal $animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHabitatName(): ?string
    {
        return $this->habitatName;
    }

    public function setHabitatName(string $habitatName): static
    {
        $this->habitatName = $habitatName;

        return $this;
    }

    public function getHabitatDescription(): ?string
    {
        return $this->habitatDescription;
    }

    public function setHabitatDescription(string $habitatDescription): static
    {
        $this->habitatDescription = $habitatDescription;

        return $this;
    }

    public function getHabitatImg(): ?string
    {
        return $this->habitatImg;
    }

    public function setHabitatImg(string $habitatImg): static
    {
        $this->habitatImg = $habitatImg;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(Animal $animal): static
    {
        // set the owning side of the relation if necessary
        if ($animal->getHabitat() !== $this) {
            $animal->setHabitat($this);
        }

        $this->animal = $animal;

        return $this;
    }
}
