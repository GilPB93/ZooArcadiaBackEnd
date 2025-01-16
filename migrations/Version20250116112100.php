<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116112100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, prenom_animal VARCHAR(128) NOT NULL, img_animal VARCHAR(255) NOT NULL, curiosites_animal LONGTEXT NOT NULL, description_animal LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitat (id INT AUTO_INCREMENT NOT NULL, habitat_name VARCHAR(128) NOT NULL, habitat_description LONGTEXT NOT NULL, habitat_img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race_animal (id INT AUTO_INCREMENT NOT NULL, race_label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_emp (id INT AUTO_INCREMENT NOT NULL, alimentation_donnee VARCHAR(255) NOT NULL, quantite_donnee VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_vet (id INT AUTO_INCREMENT NOT NULL, etat_sante LONGTEXT NOT NULL, alimentation_recommendee VARCHAR(255) NOT NULL, quantite_recommendee VARCHAR(255) NOT NULL, etat_habitat VARCHAR(255) NOT NULL, comment_habitat LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoo_horaires (id INT AUTO_INCREMENT NOT NULL, jours_semaine VARCHAR(255) NOT NULL, status_ouverture VARCHAR(255) NOT NULL, horaire_ouverture TIME NOT NULL, horaire_fermeture TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE habitat');
        $this->addSql('DROP TABLE race_animal');
        $this->addSql('DROP TABLE rapport_emp');
        $this->addSql('DROP TABLE rapport_vet');
        $this->addSql('DROP TABLE zoo_horaires');
    }
}
