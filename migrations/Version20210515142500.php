<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210515142500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidatures (id INT AUTO_INCREMENT NOT NULL, candidat_id INT DEFAULT NULL, offre_id INT DEFAULT NULL, INDEX IDX_DE57CF668D0EB82 (candidat_id), INDEX IDX_DE57CF664CC8505A (offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidatures ADD CONSTRAINT FK_DE57CF668D0EB82 FOREIGN KEY (candidat_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE candidatures ADD CONSTRAINT FK_DE57CF664CC8505A FOREIGN KEY (offre_id) REFERENCES offre_demploi (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE candidatures');
    }
}
