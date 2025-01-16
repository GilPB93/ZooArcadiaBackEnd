<?php

namespace App\Entity;

use App\Repository\RaceAnimalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaceAnimalRepository::class)]
class RaceAnimal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $raceLabel = null;

    #[ORM\OneToOne(mappedBy: 'raceAnimal', cascade: ['persist', 'remove'])]
    private ?Animal $animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaceLabel(): ?string
    {
        return $this->raceLabel;
    }

    public function setRaceLabel(string $raceLabel): static
    {
        $this->raceLabel = $raceLabel;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(Animal $animal): static
    {
        // set the owning side of the relation if necessary
        if ($animal->getRaceAnimal() !== $this) {
            $animal->setRaceAnimal($this);
        }

        $this->animal = $animal;

        return $this;
    }
}
