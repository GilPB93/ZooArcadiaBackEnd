<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\ZooContact;

class ZooContactTest extends TestCase
{
    public function testGetAndSetContactName(): void
    {
        $zooContact = new ZooContact();
        $zooContact->setContactName('Jean Dupont');

        $this->assertSame('Jean Dupont', $zooContact->getContactName());
    }

    public function testGetAndSetContactEmail(): void
    {
        $zooContact = new ZooContact();
        $zooContact->setContactEmail('jean.dupont@example.com');

        $this->assertSame('jean.dupont@example.com', $zooContact->getContactEmail());
    }

    public function testGetAndSetContactTitle(): void
    {
        $zooContact = new ZooContact();
        $zooContact->setContactTitle('Demande de renseignement');

        $this->assertSame('Demande de renseignement', $zooContact->getContactTitle());
    }

    public function testGetAndSetContactMessage(): void
    {
        $zooContact = new ZooContact();
        $zooContact->setContactMessage('Bonjour, je souhaiterais en savoir plus sur les horaires d’ouverture.');

        $this->assertSame('Bonjour, je souhaiterais en savoir plus sur les horaires d’ouverture.', $zooContact->getContactMessage());
    }

    public function testGetAndSetCreatedAt(): void
    {
        $zooContact = new ZooContact();
        $createdAt = new \DateTimeImmutable('2025-01-01 10:00:00');
        $zooContact->setCreatedAt($createdAt);

        $this->assertSame($createdAt, $zooContact->getCreatedAt());
    }

    public function testInitialValues(): void
    {
        $zooContact = new ZooContact();

        $this->assertNull($zooContact->getId());
        $this->assertNull($zooContact->getContactName());
        $this->assertNull($zooContact->getContactEmail());
        $this->assertNull($zooContact->getContactTitle());
        $this->assertNull($zooContact->getContactMessage());
        $this->assertNull($zooContact->getCreatedAt());
    }
}