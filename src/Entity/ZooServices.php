<?php

namespace App\Entity;

use App\Repository\ZooServicesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZooServicesRepository::class)]
class ZooServices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $serviceName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $serviceDescription = null;

    #[ORM\Column(length: 255)]
    private ?string $serviceImg = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $serviceName): static
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    public function getServiceDescription(): ?string
    {
        return $this->serviceDescription;
    }

    public function setServiceDescription(string $serviceDescription): static
    {
        $this->serviceDescription = $serviceDescription;

        return $this;
    }

    public function getServiceImg(): ?string
    {
        return $this->serviceImg;
    }

    public function setServiceImg(string $serviceImg): static
    {
        $this->serviceImg = $serviceImg;

        return $this;
    }
}
