<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\ZooAvis;

class ZooAvisTest extends TestCase
{
    public function testGetAndSetAvisName(): void
    {
        $zooAvis = new ZooAvis();
        $zooAvis->setAvisName('Marie Curie');

        $this->assertSame('Marie Curie', $zooAvis->getAvisName());
    }

    public function testGetAndSetAvisEmail(): void
    {
        $zooAvis = new ZooAvis();
        $zooAvis->setAvisEmail('marie.curie@example.com');

        $this->assertSame('marie.curie@example.com', $zooAvis->getAvisEmail());
    }

    public function testGetAndSetAvisTitre(): void
    {
        $zooAvis = new ZooAvis();
        $zooAvis->setAvisTitre('Excellent zoo !');

        $this->assertSame('Excellent zoo !', $zooAvis->getAvisTitre());
    }

    public function testGetAndSetAvisMessage(): void
    {
        $zooAvis = new ZooAvis();
        $zooAvis->setAvisMessage('Le zoo est bien entretenu et les animaux semblent heureux.');

        $this->assertSame('Le zoo est bien entretenu et les animaux semblent heureux.', $zooAvis->getAvisMessage());
    }

    public function testGetAndSetCreatedAt(): void
    {
        $zooAvis = new ZooAvis();
        $createdAt = new \DateTimeImmutable('2025-01-01 10:00:00');
        $zooAvis->setCreatedAt($createdAt);

        $this->assertSame($createdAt, $zooAvis->getCreatedAt());
    }

    public function testInitialValues(): void
    {
        $zooAvis = new ZooAvis();

        $this->assertNull($zooAvis->getId());
        $this->assertNull($zooAvis->getAvisName());
        $this->assertNull($zooAvis->getAvisEmail());
        $this->assertNull($zooAvis->getAvisTitre());
        $this->assertNull($zooAvis->getAvisMessage());
        $this->assertNull($zooAvis->getCreatedAt());
    }
}
