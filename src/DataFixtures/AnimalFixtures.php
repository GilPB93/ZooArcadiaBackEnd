<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\Habitat;
use App\Entity\RaceAnimal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

class AnimalFixtures extends Fixture implements DependentFixtureInterface
{
    const ANIMAL_REFERENCE = 'animal';

    public function load(ObjectManager $manager): void
    {
        $raceAnimals = $manager->getRepository(RaceAnimal::class)->findAll();
        if (count($raceAnimals) < 20) {
            throw new \Exception('Il y a moins de 20 races disponibles pour créer 20 animaux uniques.');
        }

        $habitats = $manager->getRepository(Habitat::class)->findAll();
        if (count($habitats) < 5) {
            throw new \Exception('Il y a moins de 5 habitats disponibles.');
        }

        for ($i = 1; $i <= 20; $i++) {
            $raceAnimal = $raceAnimals[$i - 1];
            $randomHabitat = $habitats[array_rand($habitats)];

            $animal = (new Animal())
                ->setPrenomAnimal("PrenomAnimal $i")
                ->setImgAnimal('https://www.example.com/animal' . $i . '.jpg')
                ->setCuriositesAnimal("Curiosites de l'animal $i")
                ->setDescriptionAnimal("Description de l'animal $i")
                ->setRaceAnimal($raceAnimal)
                ->setHabitat($randomHabitat);

            $manager->persist($animal);
            $this->addReference(self::ANIMAL_REFERENCE . $i, $animal);
        }

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            RaceAnimalFixtures::class,
            HabitatFixtures::class,
        ];
    }

}
