<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210529171033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre_demploi ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre_demploi ADD CONSTRAINT FK_8B2CD5F1BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_8B2CD5F1BCF5E72D ON offre_demploi (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre_demploi DROP FOREIGN KEY FK_8B2CD5F1BCF5E72D');
        $this->addSql('DROP INDEX IDX_8B2CD5F1BCF5E72D ON offre_demploi');
        $this->addSql('ALTER TABLE offre_demploi DROP categorie_id');
    }
}
