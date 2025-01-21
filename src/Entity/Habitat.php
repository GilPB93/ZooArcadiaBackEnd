<?php

namespace App\Entity;

use App\Repository\HabitatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

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

    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'habitat')]
    #[Groups(['habitat:read'])]
    private Collection $animals;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            // Si l'animal n'a pas déjà cet habitat, on lui affecte
            if ($animal->getHabitat() !== $this) {
                $animal->setHabitat($this);
            }
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // On réinitialise l'habitat de l'animal à null si l'animal a bien été retiré
            if ($animal->getHabitat() === $this) {
                $animal->setHabitat(null);  // Réinitialiser l'habitat
            }
        }

        return $this;
    }

}
