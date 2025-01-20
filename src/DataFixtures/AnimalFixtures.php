<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\Habitat;
use App\Entity\RaceAnimal;
use App\Entity\RapportEmp;
use App\Entity\RapportVet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnimalFixtures extends Fixture implements DependentFixtureInterface
{
    const ANIMAL_REFERENCE = 'animal';

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $animal = (new Animal())
                ->setPrenomAnimal("PrenomAnimal $i")
                ->setImgAnimal('https://www.example.com/animal' . $i . '.jpg')
                ->setDescriptionAnimal("Description de l'animal $i")
                ->setRaceAnimal($this->getReference(RaceAnimal::class, RaceAnimalFixtures::RACEANIMAL_REFERENCE . random_int(0, 20)))
                ->setHabitat($this->getReference(Habitat::class, HabitatFixtures::HABITAT_REFERENCE . random_int(0, 20)))
                ->addRapportVet($this->getReference(RapportVet::class, RapportVetFixtures::RAPPORTVET_REFERENCE . random_int(0, 10)))
                ->addRapportEmp($this->getReference(RapportEmp::class, RapportEmpFixtures::RAPPORTEMP_REFERENCE . random_int(0, 10)));


            $manager->persist($animal);
            $this->addReference(self::ANIMAL_REFERENCE.$i, $animal);
        }


        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            RaceAnimalFixtures::class,
            HabitatFixtures::class,
            RapportVetFixtures::class,
            RapportEmpFixtures::class,
        ];
    }
}
