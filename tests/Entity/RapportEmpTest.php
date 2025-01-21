<?php

namespace App\Tests\Entity;

use App\Entity\RapportEmp;
use App\Entity\User;
use App\Entity\Animal;
use PHPUnit\Framework\TestCase;

class RapportEmpTest extends TestCase
{
    public function testCreateRapportEmp(): void
    {
        $rapportEmp = new RapportEmp();
        $this->assertInstanceOf(RapportEmp::class, $rapportEmp);
        $this->assertNull($rapportEmp->getId());  // Pas d'ID au départ
        $this->assertNull($rapportEmp->getAlimentationDonnee());
        $this->assertNull($rapportEmp->getQuantiteDonnee());
        $this->assertNull($rapportEmp->getCreatedAt());
    }

    public function testSetAndGetAlimentationDonnee(): void
    {
        $rapportEmp = new RapportEmp();
        $rapportEmp->setAlimentationDonnee('Foin de qualité');
        $this->assertSame('Foin de qualité', $rapportEmp->getAlimentationDonnee());
    }

    public function testSetAndGetQuantiteDonnee(): void
    {
        $rapportEmp = new RapportEmp();
        $rapportEmp->setQuantiteDonnee('1kg par jour');
        $this->assertSame('1kg par jour', $rapportEmp->getQuantiteDonnee());
    }

    public function testSetAndGetCreatedAt(): void
    {
        $rapportEmp = new RapportEmp();
        $createdAt = new \DateTimeImmutable();
        $rapportEmp->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $rapportEmp->getCreatedAt());
    }

    public function testSetAndGetCreatedBy(): void
    {
        $rapportEmp = new RapportEmp();
        $user = $this->createMock(User::class);
        $rapportEmp->setCreatedBy($user);
        $this->assertSame($user, $rapportEmp->getCreatedBy());
    }

    public function testSetAndGetAnimal(): void
    {
        $rapportEmp = new RapportEmp();
        $animal = $this->createMock(Animal::class);
        $rapportEmp->setAnimal($animal);
        $this->assertSame($animal, $rapportEmp->getAnimal());
    }

    public function testAllSettersAndGetters(): void
    {
        $rapportEmp = new RapportEmp();

        $user = $this->createMock(User::class);
        $animal = $this->createMock(Animal::class);
        $createdAt = new \DateTimeImmutable();

        $rapportEmp->setAlimentationDonnee('Foin de qualité')
            ->setQuantiteDonnee('1kg par jour')
            ->setCreatedAt($createdAt)
            ->setCreatedBy($user)
            ->setAnimal($animal);

        // Vérification des getters après avoir utilisé les setters
        $this->assertSame('Foin de qualité', $rapportEmp->getAlimentationDonnee());
        $this->assertSame('1kg par jour', $rapportEmp->getQuantiteDonnee());
        $this->assertSame($createdAt, $rapportEmp->getCreatedAt());
        $this->assertSame($user, $rapportEmp->getCreatedBy());
        $this->assertSame($animal, $rapportEmp->getAnimal());
    }
}
