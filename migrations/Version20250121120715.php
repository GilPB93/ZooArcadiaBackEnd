<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250121120715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, race_animal_id INT DEFAULT NULL, habitat_id INT NOT NULL, prenom_animal VARCHAR(128) NOT NULL, img_animal VARCHAR(255) NOT NULL, curiosites_animal LONGTEXT NOT NULL, description_animal LONGTEXT NOT NULL, views INT NOT NULL, UNIQUE INDEX UNIQ_6AAB231F57106C0B (race_animal_id), INDEX IDX_6AAB231FAFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitat (id INT AUTO_INCREMENT NOT NULL, habitat_name VARCHAR(128) NOT NULL, habitat_description LONGTEXT NOT NULL, habitat_img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race_animal (id INT AUTO_INCREMENT NOT NULL, race_label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_emp (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, animal_id INT NOT NULL, alimentation_donnee VARCHAR(255) NOT NULL, quantite_donnee VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_C57DC3F5B03A8386 (created_by_id), INDEX IDX_C57DC3F58E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_vet (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, animal_id INT NOT NULL, etat_sante LONGTEXT NOT NULL, alimentation_recommendee VARCHAR(255) NOT NULL, quantite_recommendee VARCHAR(255) NOT NULL, etat_habitat VARCHAR(255) NOT NULL, comment_habitat LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_14A990CDB03A8386 (created_by_id), INDEX IDX_14A990CD8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom_user VARCHAR(128) NOT NULL, prenom_user VARCHAR(128) NOT NULL, api_token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoo_avis (id INT AUTO_INCREMENT NOT NULL, avis_name VARCHAR(128) NOT NULL, avis_email VARCHAR(255) NOT NULL, avis_titre VARCHAR(255) NOT NULL, avis_message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoo_contact (id INT AUTO_INCREMENT NOT NULL, contact_name VARCHAR(128) NOT NULL, contact_email VARCHAR(255) NOT NULL, contact_title VARCHAR(255) NOT NULL, contact_message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoo_horaires (id INT AUTO_INCREMENT NOT NULL, jours_semaine VARCHAR(255) NOT NULL, status_ouverture VARCHAR(255) NOT NULL, horaire_ouverture TIME NOT NULL, horaire_fermeture TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoo_services (id INT AUTO_INCREMENT NOT NULL, service_name VARCHAR(128) NOT NULL, service_description LONGTEXT NOT NULL, service_img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F57106C0B FOREIGN KEY (race_animal_id) REFERENCES race_animal (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('ALTER TABLE rapport_emp ADD CONSTRAINT FK_C57DC3F5B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rapport_emp ADD CONSTRAINT FK_C57DC3F58E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE rapport_vet ADD CONSTRAINT FK_14A990CDB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rapport_vet ADD CONSTRAINT FK_14A990CD8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F57106C0B');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FAFFE2D26');
        $this->addSql('ALTER TABLE rapport_emp DROP FOREIGN KEY FK_C57DC3F5B03A8386');
        $this->addSql('ALTER TABLE rapport_emp DROP FOREIGN KEY FK_C57DC3F58E962C16');
        $this->addSql('ALTER TABLE rapport_vet DROP FOREIGN KEY FK_14A990CDB03A8386');
        $this->addSql('ALTER TABLE rapport_vet DROP FOREIGN KEY FK_14A990CD8E962C16');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE habitat');
        $this->addSql('DROP TABLE race_animal');
        $this->addSql('DROP TABLE rapport_emp');
        $this->addSql('DROP TABLE rapport_vet');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE zoo_avis');
        $this->addSql('DROP TABLE zoo_contact');
        $this->addSql('DROP TABLE zoo_horaires');
        $this->addSql('DROP TABLE zoo_services');
    }
}
