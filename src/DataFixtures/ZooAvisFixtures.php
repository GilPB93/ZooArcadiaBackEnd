<?php

namespace App\DataFixtures;

use App\Entity\ZooAvis;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ZooAvisFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 10; $i++) {
            $zooAvis = (new ZooAvis())
                ->setAvisName("Nom $i")
                ->setAvisEmail("exemple.$i@gmail.com")
                ->setAvisTitre("Titre $i")
                ->setAvisMessage("Message $i")
                ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($zooAvis);
        }

        $manager->flush();
    }
}
