<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\RapportVet;
use App\Entity\User;
use App\Enum\etatHabitat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RapportVetFixtures extends Fixture implements DependentFixtureInterface
{
    public const RAPPORTVET_REFERENCE = 'rapportVet';

    public function load(ObjectManager $manager): void
    {
        $etatHabitatValues = EtatHabitat::cases();
        $etatHabitatRandom = $etatHabitatValues[array_rand($etatHabitatValues)];

        for ($i = 0; $i < 10; $i++) {
            $rapportVet = (new RapportVet())
                ->setEtatSante("Bon état de santé")
                ->setAlimentationRecommendee("xx alimentation")
                ->setQuantiteRecommendee("xx quantité")
                ->setEtatHabitat($etatHabitatRandom)
                ->setCreatedBy($this->getReference(User::class, UserFixtures::USER_REFERENCE.random_int(1, 20)))
                ->setAnimal($this->getReference(Animal::class, AnimalFixtures::ANIMAL_REFERENCE.random_int(1, 10)))
                ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($rapportVet);
            $this->addReference(self::RAPPORTVET_REFERENCE, $rapportVet);

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

