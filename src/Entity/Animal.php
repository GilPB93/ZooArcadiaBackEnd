<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToOne(inversedBy: 'animal', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?RaceAnimal $raceAnimal = null;

    #[ORM\OneToOne(inversedBy: 'animal', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habitat $habitat = null;

    /**
     * @var Collection<int, RapportVet>
     */
    #[ORM\OneToMany(targetEntity: RapportVet::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $rapportVet;

    /**
     * @var Collection<int, RapportEmp>
     */
    #[ORM\OneToMany(targetEntity: RapportEmp::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $rapportEmp;

    public function __construct()
    {
        $this->rapportVet = new ArrayCollection();
        $this->rapportEmp = new ArrayCollection();
    }

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

    public function getRaceAnimal(): ?RaceAnimal
    {
        return $this->raceAnimal;
    }

    public function setRaceAnimal(RaceAnimal $raceAnimal): static
    {
        $this->raceAnimal = $raceAnimal;

        return $this;
    }

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(Habitat $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    /**
     * @return Collection<int, RapportVet>
     */
    public function getRapportVet(): Collection
    {
        return $this->rapportVet;
    }

    public function addRapportVet(RapportVet $rapportVet): static
    {
        if (!$this->rapportVet->contains($rapportVet)) {
            $this->rapportVet->add($rapportVet);
            $rapportVet->setAnimal($this);
        }

        return $this;
    }

    public function removeRapportVet(RapportVet $rapportVet): static
    {
        if ($this->rapportVet->removeElement($rapportVet)) {
            // set the owning side to null (unless already changed)
            if ($rapportVet->getAnimal() === $this) {
                $rapportVet->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RapportEmp>
     */
    public function getRapportEmp(): Collection
    {
        return $this->rapportEmp;
    }

    public function addRapportEmp(RapportEmp $rapportEmp): static
    {
        if (!$this->rapportEmp->contains($rapportEmp)) {
            $this->rapportEmp->add($rapportEmp);
            $rapportEmp->setAnimal($this);
        }

        return $this;
    }

    public function removeRapportEmp(RapportEmp $rapportEmp): static
    {
        if ($this->rapportEmp->removeElement($rapportEmp)) {
            // set the owning side to null (unless already changed)
            if ($rapportEmp->getAnimal() === $this) {
                $rapportEmp->setAnimal(null);
            }
        }

        return $this;
    }
}
