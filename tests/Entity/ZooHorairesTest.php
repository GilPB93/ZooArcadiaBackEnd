<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\ZooHoraires;
use App\Enum\joursSemaine;
use App\Enum\statusOuverture;

class ZooHorairesTest extends TestCase
{
    public function testGetAndSetJoursSemaine(): void
    {
        $zooHoraires = new ZooHoraires();
        $zooHoraires->setJoursSemaine(joursSemaine::LUNDI);

        $this->assertSame(joursSemaine::LUNDI, $zooHoraires->getJoursSemaine());
    }

    public function testGetAndSetStatusOuverture(): void
    {
        $zooHoraires = new ZooHoraires();
        $zooHoraires->setStatusOuverture(statusOuverture::OUVERT);

        $this->assertSame(statusOuverture::OUVERT, $zooHoraires->getStatusOuverture());
    }

    public function testGetAndSetHoraireOuverture(): void
    {
        $zooHoraires = new ZooHoraires();
        $horaireOuverture = new \DateTime('09:00:00');
        $zooHoraires->setHoraireOuverture($horaireOuverture);

        $this->assertSame($horaireOuverture, $zooHoraires->getHoraireOuverture());
    }

    public function testGetAndSetHoraireFermeture(): void
    {
        $zooHoraires = new ZooHoraires();
        $horaireFermeture = new \DateTime('18:00:00');
        $zooHoraires->setHoraireFermeture($horaireFermeture);

        $this->assertSame($horaireFermeture, $zooHoraires->getHoraireFermeture());
    }

    public function testInitialValues(): void
    {
        $zooHoraires = new ZooHoraires();

        $this->assertNull($zooHoraires->getId());
        $this->assertNull($zooHoraires->getJoursSemaine());
        $this->assertNull($zooHoraires->getStatusOuverture());
        $this->assertNull($zooHoraires->getHoraireOuverture());
        $this->assertNull($zooHoraires->getHoraireFermeture());
    }
}