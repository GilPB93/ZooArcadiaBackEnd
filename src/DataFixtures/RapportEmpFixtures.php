<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\RapportEmp;
use App\Entity\User;
use App\Security\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RapportEmpFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) : void
    {
        $animals = $manager->getRepository(Animal::class)->findAll();
        $users = $manager->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%"'.Roles::ROLE_USER.'"%')
            ->getQuery()
            ->getResult();

        for ($i = 0; $i < 10; $i++) {
            $rapportEmp = new RapportEmp();

            $animal = $animals[$i];
            $rapportEmp->setAnimal($animal);

            $user = $users[$i];
            $rapportEmp->setCreatedBy($user);

            $rapportEmp->setAlimentationDonnee("alimentation donnée test $i");
            $rapportEmp->setQuantiteDonnee("quantité donnée $i");
            $rapportEmp->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($rapportEmp);
        }

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            AnimalFixtures::class,
            UserFixtures::class,
        ];
    }
}
