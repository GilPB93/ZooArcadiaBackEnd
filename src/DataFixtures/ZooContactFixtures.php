<?php

namespace App\DataFixtures;

use App\Entity\ZooContact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ZooContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
        $zooContact = (new ZooContact())
            ->setContactName("ExempleNom $i")
            ->setContactEmail("exemple.$i@email.com")
            ->setContactTitle("ExempleTitre $i")
            ->setContactMessage("ExempleMessage $i")
            ->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($zooContact);
        }

        $manager->flush();
    }
}
