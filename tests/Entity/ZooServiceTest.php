<?php

namespace App\Tests\Entity;

use App\Entity\ZooServices;
use PHPUnit\Framework\TestCase;

class ZooServiceTest extends TestCase
{
    public function testGetAndSetServiceName(): void
    {
        $zooService = new ZooServices();
        $zooService->setServiceName('Safari Tour');

        $this->assertSame('Safari Tour', $zooService->getServiceName());
    }

    public function testGetAndSetServiceDescription(): void
    {
        $zooService = new ZooServices();
        $zooService->setServiceDescription('Une visite guidée pour explorer la faune.');

        $this->assertSame('Une visite guidée pour explorer la faune.', $zooService->getServiceDescription());
    }

    public function testGetAndSetServiceImg(): void
    {
        $zooService = new ZooServices();
        $zooService->setServiceImg('safari-tour.jpg');

        $this->assertSame('safari-tour.jpg', $zooService->getServiceImg());
    }

    public function testInitialValues(): void
    {
        $zooService = new ZooServices();

        $this->assertNull($zooService->getId());
        $this->assertNull($zooService->getServiceName());
        $this->assertNull($zooService->getServiceDescription());
        $this->assertNull($zooService->getServiceImg());
    }
}