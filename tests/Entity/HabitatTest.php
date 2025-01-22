<?php

namespace App\Tests\Entity;

use App\Entity\Habitat;
use App\Entity\Animal;
use PHPUnit\Framework\TestCase;

class HabitatTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $habitat = new Habitat();

        $habitat->setHabitatName('Jungle');
        $this->assertSame('Jungle', $habitat->getHabitatName());

        $habitat->setHabitatDescription('Une jungle tropicale avec beaucoup de végétation.');
        $this->assertSame('Une jungle tropicale avec beaucoup de végétation.', $habitat->getHabitatDescription());

        $habitat->setHabitatImg('jungle.jpg');
        $this->assertSame('jungle.jpg', $habitat->getHabitatImg());
    }

    public function testAddAnimal()
    {
        $habitat = new Habitat();
        $animal = new Animal();

        $habitat->addAnimal($animal);

        $this->assertCount(1, $habitat->getAnimals());
        $this->assertTrue($habitat->getAnimals()->contains($animal));

        // Vérifier la relation inverse
        $this->assertSame($habitat, $animal->getHabitat());
    }

    public function testRemoveAnimal()
    {
        $habitat = new Habitat();
        $animal = new Animal();

        $habitat->addAnimal($animal);
        $this->assertCount(1, $habitat->getAnimals());

        $habitat->removeAnimal($animal);

        $this->assertCount(0, $habitat->getAnimals());
        $this->assertFalse($habitat->getAnimals()->contains($animal));

        // Vérifier la relation inverse
        $this->assertNull($animal->getHabitat());
    }

    public function testAddAnimalOnlyOnce()
    {
        $habitat = new Habitat();
        $animal = new Animal();

        $habitat->addAnimal($animal);
        $habitat->addAnimal($animal);

        $this->assertCount(1, $habitat->getAnimals());
    }

    public function testRemoveAnimalNotPresent()
    {
        $habitat = new Habitat();
        $animal = new Animal();

        // Essayer de retirer un animal qui n'est pas dans la collection
        $habitat->removeAnimal($animal);

        $this->assertCount(0, $habitat->getAnimals());
    }
}