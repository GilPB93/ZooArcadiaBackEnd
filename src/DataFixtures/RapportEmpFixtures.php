<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\RapportEmp;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Tests\Common\DataFixtures\TestFixtures\UserFixture;

class RapportEmpFixtures extends Fixture implements DependentFixtureInterface
{
    public const RAPPORTEMP_REFERENCE = 'rapportEmp';

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $rapportEmp = (new RapportEmp())
                ->setAlimentationDonnee("xx alimentation")
                ->setQuantiteDonnee("xx quantité")
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy($this->getReference(User::class, UserFixtures::USER_REFERENCE.random_int(1, 20)))
                ->setAnimal($this->getReference(Animal::class, AnimalFixtures::ANIMAL_REFERENCE.random_int(1, 10)));

            $manager->persist($rapportEmp);
            $this->addReference(self::RAPPORTEMP_REFERENCE, $rapportEmp);

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            AnimalFixtures::class,
        ];
    }
}
