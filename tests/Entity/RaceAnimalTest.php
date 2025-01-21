<?php

namespace App\Tests\Entity;

use App\Entity\RaceAnimal;
use App\Entity\Animal;
use PHPUnit\Framework\TestCase;

class RaceAnimalTest extends TestCase
{
    public function testCreateRaceAnimal(): void
    {
        $raceAnimal = new RaceAnimal();
        $this->assertInstanceOf(RaceAnimal::class, $raceAnimal);
        $this->assertNull($raceAnimal->getId());  // Pas d'ID au départ
        $this->assertNull($raceAnimal->getRaceLabel());
        $this->assertNull($raceAnimal->getAnimal());
    }

    public function testSetAndGetRaceLabel(): void
    {
        $raceAnimal = new RaceAnimal();
        $raceAnimal->setRaceLabel('Bengal');
        $this->assertSame('Bengal', $raceAnimal->getRaceLabel());
    }

    public function testSetAndGetAnimal(): void
    {
        $raceAnimal = new RaceAnimal();
        $animal = $this->createMock(Animal::class);
        $raceAnimal->setAnimal($animal);
        $this->assertSame($animal, $raceAnimal->getAnimal());
    }

    public function testSetAndGetAnimalWithRelation(): void
    {
        $raceAnimal = new RaceAnimal();
        $animal = $this->createMock(Animal::class);

        // Simuler la relation avec l'animal
        $animal->method('getRaceAnimal')->willReturn(null);

        $raceAnimal->setAnimal($animal);

        // Vérifier que l'animal est bien lié à la race
        $this->assertSame($animal, $raceAnimal->getAnimal());

        // Vérification de la mise à jour de la relation dans l'animal
        $animal->method('setRaceAnimal')->with($raceAnimal);
    }

    public function testAllSettersAndGetters(): void
    {
        $raceAnimal = new RaceAnimal();
        $animal = $this->createMock(Animal::class);

        $raceAnimal->setRaceLabel('Persan')
            ->setAnimal($animal);

        // Vérification des getters après avoir utilisé les setters
        $this->assertSame('Persan', $raceAnimal->getRaceLabel());
        $this->assertSame($animal, $raceAnimal->getAnimal());
    }
}
