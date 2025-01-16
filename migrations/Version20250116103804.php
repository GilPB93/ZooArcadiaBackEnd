<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116103804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE zoo_avis (id INT AUTO_INCREMENT NOT NULL, avis_name VARCHAR(128) NOT NULL, avis_email VARCHAR(255) NOT NULL, avis_titre VARCHAR(255) NOT NULL, avis_message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoo_contact (id INT AUTO_INCREMENT NOT NULL, contact_name VARCHAR(128) NOT NULL, contact_email VARCHAR(255) NOT NULL, contact_title VARCHAR(255) NOT NULL, contact_message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoo_services (id INT AUTO_INCREMENT NOT NULL, service_name VARCHAR(128) NOT NULL, service_description LONGTEXT NOT NULL, service_img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE zoo_avis');
        $this->addSql('DROP TABLE zoo_contact');
        $this->addSql('DROP TABLE zoo_services');
    }
}
