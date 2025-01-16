<?php

namespace App\Entity;

use App\Enum\joursSemaine;
use App\Enum\statusOuverture;
use App\Repository\ZooHorairesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZooHorairesRepository::class)]
class ZooHoraires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: joursSemaine::class)]
    private ?joursSemaine $joursSemaine = null;

    #[ORM\Column(enumType: statusOuverture::class)]
    private ?statusOuverture $statusOuverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaireOuverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaireFermeture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJoursSemaine(): ?joursSemaine
    {
        return $this->joursSemaine;
    }

    public function setJoursSemaine(joursSemaine $joursSemaine): static
    {
        $this->joursSemaine = $joursSemaine;

        return $this;
    }

    public function getStatusOuverture(): ?statusOuverture
    {
        return $this->statusOuverture;
    }

    public function setStatusOuverture(statusOuverture $statusOuverture): static
    {
        $this->statusOuverture = $statusOuverture;

        return $this;
    }

    public function getHoraireOuverture(): ?\DateTimeInterface
    {
        return $this->horaireOuverture;
    }

    public function setHoraireOuverture(\DateTimeInterface $horaireOuverture): static
    {
        $this->horaireOuverture = $horaireOuverture;

        return $this;
    }

    public function getHoraireFermeture(): ?\DateTimeInterface
    {
        return $this->horaireFermeture;
    }

    public function setHoraireFermeture(\DateTimeInterface $horaireFermeture): static
    {
        $this->horaireFermeture = $horaireFermeture;

        return $this;
    }
}