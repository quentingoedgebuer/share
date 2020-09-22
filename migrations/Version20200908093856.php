<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908093856 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE telechargement ADD fichier_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE telechargement ADD CONSTRAINT FK_E8C7D809481D2A6F FOREIGN KEY (fichier_id_id) REFERENCES fichier (id)');
        $this->addSql('CREATE INDEX IDX_E8C7D809481D2A6F ON telechargement (fichier_id_id)');
        $this->addSql('ALTER TABLE utilisateur ADD utilisateur_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3B981C689 FOREIGN KEY (utilisateur_id_id) REFERENCES fichier (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3B981C689 ON utilisateur (utilisateur_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE telechargement DROP FOREIGN KEY FK_E8C7D809481D2A6F');
        $this->addSql('DROP INDEX IDX_E8C7D809481D2A6F ON telechargement');
        $this->addSql('ALTER TABLE telechargement DROP fichier_id_id');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3B981C689');
        $this->addSql('DROP INDEX IDX_1D1C63B3B981C689 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP utilisateur_id_id');
    }
}
