<?php

namespace App\DataFixtures;

use App\Entity\RaceAnimal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RaceAnimalFixtures extends Fixture
{
    public const RACEANIMAL_REFERENCE = 'raceAnimal';

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $raceAnimal = (new RaceAnimal())
                ->setRaceLabel("Race Animal $i");

            $manager->persist($raceAnimal);
            $this->addReference(self::RACEANIMAL_REFERENCE . $i, $raceAnimal);
        }

        $manager->flush();
    }
}
