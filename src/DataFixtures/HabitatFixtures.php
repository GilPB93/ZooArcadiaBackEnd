<?php

namespace App\DataFixtures;

use App\Entity\Habitat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HabitatFixtures extends Fixture
{
    public const HABITAT_REFERENCE = 'habitat';

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 5; $i++) {
            $habitat = (new Habitat())
                ->setHabitatName('Habitat ' . $i)
                ->setHabitatDescription('Description of habitat ' . $i)
                ->setHabitatImg('https://www.example.com/habitat' . $i . '.jpg');

            $manager->persist($habitat);
            $this->addReference(self::HABITAT_REFERENCE . $i, $habitat);
        }

        $manager->flush();
    }
}
