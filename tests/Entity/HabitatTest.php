<?php

namespace App\Tests\Entity;

use App\Entity\Habitat;
use App\Entity\Animal;
use PHPUnit\Framework\TestCase;

class HabitatTest extends TestCase
{
    public function testSetAndGetHabitatName()
    {
        $habitat = new Habitat();
        $habitat->setHabitatName('Forêt tropicale');

        $this->assertEquals('Forêt tropicale', $habitat->getHabitatName());
    }

    public function testSetAndGetHabitatDescription()
    {
        $habitat = new Habitat();
        $description = 'Une forêt dense située près de l\'équateur';
        $habitat->setHabitatDescription($description);

        $this->assertEquals($description, $habitat->getHabitatDescription());
    }

    public function testSetAndGetHabitatImg()
    {
        $habitat = new Habitat();
        $image = 'forêt_tropicale.jpg';
        $habitat->setHabitatImg($image);

        $this->assertEquals($image, $habitat->getHabitatImg());
    }

    public function testAddAnimal()
    {
        $habitat = new Habitat();
        $animal = $this->createMock(Animal::class);

        $animal->expects($this->once())
            ->method('setHabitat')
            ->with($habitat);

        $habitat->addAnimal($animal);

        $this->assertCount(1, $habitat->getAnimals());
    }

    public function testRemoveAnimal()
    {
        $habitat = new Habitat();
        $animal = $this->createMock(Animal::class);

        $animal->method('getHabitat')
            ->willReturn($habitat);

        $animal->expects($this->once())
            ->method('setHabitat')
            ->with($habitat);

        $habitat->addAnimal($animal);

        $animal->expects($this->once())
            ->method('setHabitat')
            ->with($this->logicalOr($this->equalTo(null), $this->isInstanceOf(Habitat::class)));

        $habitat->removeAnimal($animal);

        $this->assertCount(0, $habitat->getAnimals());
    }

    public function testGetAnimals()
    {
        $habitat = new Habitat();
        $animal = $this->createMock(Animal::class);

        $habitat->addAnimal($animal);

        $animals = $habitat->getAnimals();
        $this->assertInstanceOf(\Doctrine\Common\Collections\Collection::class, $animals);
        $this->assertCount(1, $animals);
    }
}