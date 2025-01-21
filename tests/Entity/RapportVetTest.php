<?php

namespace App\Tests\Entity;

use App\Entity\RapportVet;
use App\Entity\User;
use App\Entity\Animal;
use App\Enum\etatHabitat;
use PHPUnit\Framework\TestCase;

class RapportVetTest extends TestCase
{
    public function testCreateRapportVet(): void
    {
        $rapportVet = new RapportVet();
        $this->assertInstanceOf(RapportVet::class, $rapportVet);
        $this->assertNull($rapportVet->getId());  // Pas d'ID au départ
        $this->assertNull($rapportVet->getEtatSante());
        $this->assertNull($rapportVet->getAlimentationRecommendee());
        $this->assertNull($rapportVet->getQuantiteRecommendee());
        $this->assertNull($rapportVet->getEtatHabitat());
        $this->assertNull($rapportVet->getCreatedAt());
    }

    public function testSetAndGetEtatSante(): void
    {
        $rapportVet = new RapportVet();
        $rapportVet->setEtatSante('Bonne santé');
        $this->assertSame('Bonne santé', $rapportVet->getEtatSante());
    }

    public function testSetAndGetAlimentationRecommendee(): void
    {
        $rapportVet = new RapportVet();
        $rapportVet->setAlimentationRecommendee('Croquettes pour chiens');
        $this->assertSame('Croquettes pour chiens', $rapportVet->getAlimentationRecommendee());
    }

    public function testSetAndGetQuantiteRecommendee(): void
    {
        $rapportVet = new RapportVet();
        $rapportVet->setQuantiteRecommendee('200g par jour');
        $this->assertSame('200g par jour', $rapportVet->getQuantiteRecommendee());
    }

    public function testSetAndGetEtatHabitat(): void
    {
        $rapportVet = new RapportVet();
        $etatHabitat = etatHabitat::BON_ETAT; // Valeur de l'énumération
        $rapportVet->setEtatHabitat($etatHabitat);
        $this->assertSame($etatHabitat, $rapportVet->getEtatHabitat());
    }

    public function testSetAndGetCommentHabitat(): void
    {
        $rapportVet = new RapportVet();
        $rapportVet->setCommentHabitat('L\'habitat est propre et spacieux.');
        $this->assertSame('L\'habitat est propre et spacieux.', $rapportVet->getCommentHabitat());
    }

    public function testSetAndGetCreatedAt(): void
    {
        $rapportVet = new RapportVet();
        $createdAt = new \DateTimeImmutable();
        $rapportVet->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $rapportVet->getCreatedAt());
    }

    public function testSetAndGetCreatedBy(): void
    {
        $rapportVet = new RapportVet();
        $user = $this->createMock(User::class);
        $rapportVet->setCreatedBy($user);
        $this->assertSame($user, $rapportVet->getCreatedBy());
    }

    public function testSetAndGetAnimal(): void
    {
        $rapportVet = new RapportVet();
        $animal = $this->createMock(Animal::class);
        $rapportVet->setAnimal($animal);
        $this->assertSame($animal, $rapportVet->getAnimal());
    }

    public function testAddAndRemoveRapportVet(): void
    {
        // Créez un mock pour l'entité RapportVet
        $rapportVetMock = $this->createMock(RapportVet::class);

        // Créez une instance de l'entité Animal
        $animal = new Animal();

        // Attendez-vous à ce que la méthode setAnimal soit appelée une fois
        $rapportVetMock->expects($this->once())
            ->method('setAnimal')
            ->with($animal);

        // Ajoutez le RapportVet à l'animal
        $animal->addRapportVet($rapportVetMock);

        // Testez la suppression du RapportVet
        $animal->removeRapportVet($rapportVetMock);

        // Vous pouvez aussi vérifier si le rapport a bien été retiré
        $this->assertCount(0, $animal->getRapportVet());
    }

    public function testAllSettersAndGetters(): void
    {
        $rapportVet = new RapportVet();

        $etatHabitat = etatHabitat::BON_ETAT; // Enum
        $user = $this->createMock(User::class);
        $animal = $this->createMock(Animal::class);
        $createdAt = new \DateTimeImmutable();

        $rapportVet->setEtatSante('Bonne santé')
            ->setAlimentationRecommendee('Croquettes pour chiens')
            ->setQuantiteRecommendee('200g par jour')
            ->setEtatHabitat($etatHabitat)
            ->setCommentHabitat('L\'habitat est propre et spacieux.')
            ->setCreatedAt($createdAt)
            ->setCreatedBy($user)
            ->setAnimal($animal);

        // Vérification des getters après avoir utilisé les setters
        $this->assertSame('Bonne santé', $rapportVet->getEtatSante());
        $this->assertSame('Croquettes pour chiens', $rapportVet->getAlimentationRecommendee());
        $this->assertSame('200g par jour', $rapportVet->getQuantiteRecommendee());
        $this->assertSame($etatHabitat, $rapportVet->getEtatHabitat());
        $this->assertSame('L\'habitat est propre et spacieux.', $rapportVet->getCommentHabitat());
        $this->assertSame($createdAt, $rapportVet->getCreatedAt());
        $this->assertSame($user, $rapportVet->getCreatedBy());
        $this->assertSame($animal, $rapportVet->getAnimal());
    }
}
