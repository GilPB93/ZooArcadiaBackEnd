<?php

namespace App\Tests\Entity;

use App\Entity\Animal;
use App\Entity\Habitat;
use App\Entity\RaceAnimal;
use App\Entity\RapportVet;
use App\Entity\RapportEmp;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;

class AnimalTest extends TestCase
{
    public function testInitialisationAnimal()
    {
        $animal = new Animal();

        $this->assertNull($animal->getId());
        $this->assertNull($animal->getPrenomAnimal());
        $this->assertNull($animal->getImgAnimal());
        $this->assertNull($animal->getCuriositesAnimal());
        $this->assertNull($animal->getDescriptionAnimal());
        $this->assertEquals(0, $animal->getViews());
        $this->assertNull($animal->getRaceAnimal());
        $this->assertNull($animal->getHabitat());
        $this->assertInstanceOf(ArrayCollection::class, $animal->getRapportVet());
        $this->assertInstanceOf(ArrayCollection::class, $animal->getRapportEmp());
    }

    public function testSetterGetterPrenomAnimal()
    {
        $animal = new Animal();
        $prenom = 'Lion';

        $animal->setPrenomAnimal($prenom);

        $this->assertEquals($prenom, $animal->getPrenomAnimal());
    }

    public function testSetterGetterImgAnimal()
    {
        $animal = new Animal();
        $image = 'lion.jpg';

        $animal->setImgAnimal($image);

        $this->assertEquals($image, $animal->getImgAnimal());
    }

    public function testSetterGetterCuriositesAnimal()
    {
        $animal = new Animal();
        $curiosites = 'Il aime dormir sous les arbres.';

        $animal->setCuriositesAnimal($curiosites);

        $this->assertEquals($curiosites, $animal->getCuriositesAnimal());
    }

    public function testSetterGetterDescriptionAnimal()
    {
        $animal = new Animal();
        $description = 'Le lion est le roi de la savane.';

        $animal->setDescriptionAnimal($description);

        $this->assertEquals($description, $animal->getDescriptionAnimal());
    }

    public function testIncrementViews()
    {
        $animal = new Animal();

        // Vérification du nombre de vues avant l'incrémentation
        $this->assertEquals(0, $animal->getViews());

        $animal->incrementViews();

        // Vérification du nombre de vues après l'incrémentation
        $this->assertEquals(1, $animal->getViews());
    }

    public function testSetterGetterRaceAnimal()
    {
        $animal = new Animal();
        $race = new RaceAnimal(); // Simulation d'un objet RaceAnimal

        $animal->setRaceAnimal($race);

        $this->assertSame($race, $animal->getRaceAnimal());
    }

    public function testSetterGetterHabitat()
    {
        $animal = new Animal();
        $habitat = new Habitat(); // Simulation d'un objet Habitat

        $animal->setHabitat($habitat);

        $this->assertSame($habitat, $animal->getHabitat());
    }

    public function testAddRemoveRapportVet()
    {
        $animal = new Animal();
        $rapportVet = new RapportVet(); // Simulation d'un objet RapportVet

        $animal->addRapportVet($rapportVet);
        $this->assertCount(1, $animal->getRapportVet());

        $animal->removeRapportVet($rapportVet);
        $this->assertCount(0, $animal->getRapportVet());
    }

    public function testAddRemoveRapportEmp()
    {
        $animal = new Animal();
        $rapportEmp = new RapportEmp(); // Simulation d'un objet RapportEmp

        $animal->addRapportEmp($rapportEmp);
        $this->assertCount(1, $animal->getRapportEmp());

        $animal->removeRapportEmp($rapportEmp);
        $this->assertCount(0, $animal->getRapportEmp());
    }

    public function testAddRapportVetToAnimal()
    {
        $animal = new Animal();
        $rapportVet = new RapportVet();

        $animal->addRapportVet($rapportVet);

        $this->assertTrue($animal->getRapportVet()->contains($rapportVet));
    }

    public function testAddRapportEmpToAnimal()
    {
        $animal = new Animal();
        $rapportEmp = new RapportEmp();

        $animal->addRapportEmp($rapportEmp);

        $this->assertTrue($animal->getRapportEmp()->contains($rapportEmp));
    }
}
