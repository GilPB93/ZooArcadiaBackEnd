<?php

namespace App\DataFixtures;

use App\Entity\ZooServices;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ZooServicesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $zooServices = (new ZooServices())
                ->setServiceName("Service $i")
                ->setServiceDescription("Description du service $i")
                ->setServiceImg('https://www.example.com/service' . $i . '.jpg');

            $manager->persist($zooServices);
        }

        $manager->flush();
    }
}
