<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210529170454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD6341CD081E5');
        $this->addSql('DROP INDEX UNIQ_497DD6341CD081E5 ON categorie');
        $this->addSql('ALTER TABLE categorie DROP offre_demploi_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD offre_demploi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD6341CD081E5 FOREIGN KEY (offre_demploi_id) REFERENCES offre_demploi (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497DD6341CD081E5 ON categorie (offre_demploi_id)');
    }
}
