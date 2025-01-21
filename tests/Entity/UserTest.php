<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Security\Roles;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserTest extends TestCase
{
    public function testGetId(): void
    {
        $user = new User();
        $this->assertNull($user->getId());
    }

    public function testSetEmail(): void
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $this->assertSame('test@example.com', $user->getEmail());
    }

    public function testGetUserIdentifier(): void
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $this->assertSame('test@example.com', $user->getUserIdentifier());
    }

    public function testGetRoles(): void
    {
        $user = new User();
        $user->setRoles([Roles::ROLE_ADMIN]);
        $this->assertContains(Roles::ROLE_USER, $user->getRoles());  // ROLE_USER doit être présent par défaut
        $this->assertContains(Roles::ROLE_ADMIN, $user->getRoles());
    }

    public function testAddRole(): void
    {
        $user = new User();
        $user->addRole(Roles::ROLE_ADMIN);
        $this->assertContains(Roles::ROLE_ADMIN, $user->getRoles());
    }

    public function testRemoveRole(): void
    {
        $user = new User();
        $user->addRole(Roles::ROLE_ADMIN);
        $user->removeRole(Roles::ROLE_ADMIN);
        $this->assertNotContains(Roles::ROLE_ADMIN, $user->getRoles());
    }

    public function testSetPassword(): void
    {
        $user = new User();
        $user->setPassword('password123');
        $this->assertSame('password123', $user->getPassword());
    }

    public function testEraseCredentials(): void
    {
        $user = new User();
        $user->eraseCredentials();
        $this->assertNull($user->getPassword()); // Si des données sensibles sont stockées, elles devraient être effacées
    }

    public function testNomUserAndPrenomUser(): void
    {
        $user = new User();
        $user->setNomUser('Dupont');
        $user->setPrenomUser('Jean');
        $this->assertSame('Dupont', $user->getNomUser());
        $this->assertSame('Jean', $user->getPrenomUser());
    }

    public function testSetCreatedAt(): void
    {
        $user = new User();
        $createdAt = new \DateTimeImmutable();
        $user->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $user->getCreatedAt());
    }

    public function testRapportEmpAndRapportVet(): void
    {
        $user = new User();

        $rapportEmp = $this->createMock(\App\Entity\RapportEmp::class);
        $rapportVet = $this->createMock(\App\Entity\RapportVet::class);

        $user->setRapportEmp($rapportEmp);
        $user->setRapportVet($rapportVet);

        $this->assertSame($rapportEmp, $user->getRapportEmp());
        $this->assertSame($rapportVet, $user->getRapportVet());
    }

    public function testApiTokenGeneration(): void
    {
        $user = new User();
        $this->assertNotNull($user->getApiToken());  // Vérifie que l'API Token est généré
        $this->assertEquals(40, strlen($user->getApiToken()));  // Un apiToken de 40 caractères
    }
}
