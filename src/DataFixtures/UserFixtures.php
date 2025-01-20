<?php

namespace App\DataFixtures;

use App\Entity\User;
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
        for ($i = 0; $i < 20; $i++) {
            $user = (new User())
                ->setEmail("exemple.$i@email.com")
                ->setNomUser("NomUser $i")
                ->setPrenomUser("PrenomUser $i")
                ->setCreatedAt(new \DateTimeImmutable());

            $roles = rand(0, 1) === 0 ? ['ROLE_EMPLOYE'] : ['ROLE_VETERINAIRE'];
            $user->setRoles($roles);

            $user->setPassword($this->passwordHasher->hashPassword($user,"Password@.$i"));


            $manager->persist($user);
            $this->addReference(self::USER_REFERENCE . $i, $user);
        }


        $manager->flush();
    }
}
