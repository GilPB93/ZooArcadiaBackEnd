<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Security\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Ajout d'un administrateur
       $admin = (new User())
            ->setEmail("admin@email.com")
            ->setNomUser("AdminUser")
            ->setPrenomUser("Admin")
            ->setRoles([Roles::ROLE_ADMIN])
            ->setCreatedAt(new \DateTimeImmutable());
        $admin->setPassword($this->passwordHasher->hashPassword($admin, "AdminPassword@123"));
        $manager->persist($admin);

        // Ajout d'utilisateurs classiques et vétérinaires
        $veterinaireCount = 0;
        for ($i = 1; $i <= 20; $i++) {
            $user = (new User())
                ->setEmail("exemple.$i@email.com")
                ->setNomUser("NomUser $i")
                ->setPrenomUser("PrenomUser $i")
                ->setCreatedAt(new \DateTimeImmutable());

            $roles = [Roles::ROLE_USER];
            if ($veterinaireCount < 5 && rand(0, 1) === 0) {
                $roles = [Roles::ROLE_VETERINAIRE];
                $veterinaireCount++;
            }

            $user->setRoles($roles);
            $user->setPassword($this->passwordHasher->hashPassword($user, "Password@.$i"));
            $manager->persist($user);
            $this->addReference(self::USER_REFERENCE . $i, $user);
        }

        $manager->flush();
    }

}
