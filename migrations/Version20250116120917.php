<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116120917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD race_animal_id INT NOT NULL, ADD habitat_id INT NOT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F57106C0B FOREIGN KEY (race_animal_id) REFERENCES race_animal (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AAB231F57106C0B ON animal (race_animal_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AAB231FAFFE2D26 ON animal (habitat_id)');
        $this->addSql('ALTER TABLE rapport_emp ADD created_by_id INT NOT NULL, ADD animal_id INT NOT NULL');
        $this->addSql('ALTER TABLE rapport_emp ADD CONSTRAINT FK_C57DC3F5B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rapport_emp ADD CONSTRAINT FK_C57DC3F58E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C57DC3F5B03A8386 ON rapport_emp (created_by_id)');
        $this->addSql('CREATE INDEX IDX_C57DC3F58E962C16 ON rapport_emp (animal_id)');
        $this->addSql('ALTER TABLE rapport_vet ADD created_by_id INT NOT NULL, ADD animal_id INT NOT NULL');
        $this->addSql('ALTER TABLE rapport_vet ADD CONSTRAINT FK_14A990CDB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rapport_vet ADD CONSTRAINT FK_14A990CD8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_14A990CDB03A8386 ON rapport_vet (created_by_id)');
        $this->addSql('CREATE INDEX IDX_14A990CD8E962C16 ON rapport_vet (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F57106C0B');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FAFFE2D26');
        $this->addSql('DROP INDEX UNIQ_6AAB231F57106C0B ON animal');
        $this->addSql('DROP INDEX UNIQ_6AAB231FAFFE2D26 ON animal');
        $this->addSql('ALTER TABLE animal DROP race_animal_id, DROP habitat_id');
        $this->addSql('ALTER TABLE rapport_emp DROP FOREIGN KEY FK_C57DC3F5B03A8386');
        $this->addSql('ALTER TABLE rapport_emp DROP FOREIGN KEY FK_C57DC3F58E962C16');
        $this->addSql('DROP INDEX UNIQ_C57DC3F5B03A8386 ON rapport_emp');
        $this->addSql('DROP INDEX IDX_C57DC3F58E962C16 ON rapport_emp');
        $this->addSql('ALTER TABLE rapport_emp DROP created_by_id, DROP animal_id');
        $this->addSql('ALTER TABLE rapport_vet DROP FOREIGN KEY FK_14A990CDB03A8386');
        $this->addSql('ALTER TABLE rapport_vet DROP FOREIGN KEY FK_14A990CD8E962C16');
        $this->addSql('DROP INDEX UNIQ_14A990CDB03A8386 ON rapport_vet');
        $this->addSql('DROP INDEX IDX_14A990CD8E962C16 ON rapport_vet');
        $this->addSql('ALTER TABLE rapport_vet DROP created_by_id, DROP animal_id');
    }
}
