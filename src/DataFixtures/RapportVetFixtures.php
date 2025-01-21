<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\RapportVet;
use App\Entity\User;
use App\Enum\etatHabitat;
use App\Security\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RapportVetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) : void
    {
        // Récupérer les animaux existants depuis AnimalFixtures
        $animals = $manager->getRepository(Animal::class)->findAll();
        // Récupérer les utilisateurs avec le rôle ROLE_VETERINAIRE
        $users = $manager->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%"'.Roles::ROLE_VETERINAIRE.'"%')
            ->getQuery()
            ->getResult();

        // Créer 5 rapports vétérinaires avec des animaux et des vétérinaires uniques
        for ($i = 0; $i < 5; $i++) {
            $rapportVet = new RapportVet();

            // Associer un animal unique
            $animal = $animals[$i]; // Assurez-vous que vous avez au moins 5 animaux dans la base de données
            $rapportVet->setAnimal($animal);

            // Associer un vétérinaire unique (role ROLE_VETERINAIRE)
            $user = $users[$i]; // Assurez-vous que vous avez au moins 5 vétérinaires
            $rapportVet->setCreatedBy($user);

            // Définir les autres propriétés du rapport
            $rapportVet->setEtatSante('bonne santé test');
            $rapportVet->setAlimentationRecommendee("alimentation test $i");
            $rapportVet->setQuantiteRecommendee("quantité test $i");
            $rapportVet->setEtatHabitat(etatHabitat::BON_ETAT);
            $rapportVet->setCommentHabitat("commentaire test $i");
            $rapportVet->setCreatedAt(new \DateTimeImmutable());

            // Persister le rapport
            $manager->persist($rapportVet);
        }

        // Sauvegarder toutes les entités persistées
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
