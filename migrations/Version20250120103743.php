<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250120103743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Cette migration ne va pas ajouter de clé étrangère
        $this->addSql('ALTER TABLE animal CHANGE habitat_id habitat_id INT NOT NULL');
        // Supprimer la ligne suivante pour ne pas ajouter la clé étrangère
        // $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        // Supprimer la ligne suivante si vous ne voulez pas ajouter un index
        // $this->addSql('CREATE INDEX IDX_6AAB231FAFFE2D26 ON animal (habitat_id)');
    }

    public function down(Schema $schema): void
    {
        // Annuler les changements sans la contrainte de clé étrangère
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FAFFE2D26');  // Cette ligne ne sera pas applicable
        $this->addSql('DROP INDEX IDX_6AAB231FAFFE2D26 ON animal');  // Cette ligne ne sera pas applicable non plus
        $this->addSql('ALTER TABLE animal CHANGE habitat_id habitat_id INT DEFAULT NULL');
    }
}
