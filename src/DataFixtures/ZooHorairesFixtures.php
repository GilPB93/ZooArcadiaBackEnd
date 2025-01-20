<?php

namespace App\DataFixtures;

use App\Entity\ZooHoraires;
use App\Enum\joursSemaine;
use App\Enum\statusOuverture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ZooHorairesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $zooHoraires = (new ZooHoraires())
            ->setJoursSemaine(joursSemaine::LUNDI)
            ->setStatusOuverture(statusOuverture::OUVERT)
            ->setHoraireOuverture(new \DateTime("08:00:00"))
            ->setHoraireFermeture(new \DateTime("20:00:00"));
        $manager->persist($zooHoraires);

        $zooHoraires = (new ZooHoraires())
            ->setJoursSemaine(joursSemaine::MARDI)
            ->setStatusOuverture(statusOuverture::OUVERT)
            ->setHoraireOuverture(new \DateTime("08:00:00"))
            ->setHoraireFermeture(new \DateTime("20:00:00"));
        $manager->persist($zooHoraires);

        $zooHoraires = (new ZooHoraires())
            ->setJoursSemaine(joursSemaine::MERCREDI)
            ->setStatusOuverture(statusOuverture::OUVERT)
            ->setHoraireOuverture(new \DateTime("08:00:00"))
            ->setHoraireFermeture(new \DateTime("20:00:00"));
        $manager->persist($zooHoraires);

        $zooHoraires = (new ZooHoraires())
            ->setJoursSemaine(joursSemaine::JEUDI)
            ->setStatusOuverture(statusOuverture::OUVERT)
            ->setHoraireOuverture(new \DateTime("08:00:00"))
            ->setHoraireFermeture(new \DateTime("20:00:00"));
        $manager->persist($zooHoraires);

        $zooHoraires = (new ZooHoraires())
            ->setJoursSemaine(joursSemaine::VENDREDI)
            ->setStatusOuverture(statusOuverture::OUVERT)
            ->setHoraireOuverture(new \DateTime("08:00:00"))
            ->setHoraireFermeture(new \DateTime("20:00:00"));
        $manager->persist($zooHoraires);

        $zooHoraires = (new ZooHoraires())
            ->setJoursSemaine(joursSemaine::SAMEDI)
            ->setStatusOuverture(statusOuverture::OUVERT)
            ->setHoraireOuverture(new \DateTime("08:00:00"))
            ->setHoraireFermeture(new \DateTime("20:00:00"));
        $manager->persist($zooHoraires);

        $zooHoraires = (new ZooHoraires())
            ->setJoursSemaine(joursSemaine::DIMANCHE)
            ->setStatusOuverture(statusOuverture::OUVERT)
            ->setHoraireOuverture(new \DateTime("08:00:00"))
            ->setHoraireFermeture(new \DateTime("20:00:00"));
        $manager->persist($zooHoraires);


        $manager->flush();
    }

}
