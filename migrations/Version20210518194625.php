<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518194625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personelle DROP FOREIGN KEY FK_56C785F415761DAB');
        $this->addSql('DROP INDEX IDX_56C785F415761DAB ON personelle');
        $this->addSql('ALTER TABLE personelle CHANGE competence_id candidat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personelle ADD CONSTRAINT FK_56C785F48D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('CREATE INDEX IDX_56C785F48D0EB82 ON personelle (candidat_id)');
        $this->addSql('ALTER TABLE professionelle DROP FOREIGN KEY FK_A7CFF38415761DAB');
        $this->addSql('DROP INDEX IDX_A7CFF38415761DAB ON professionelle');
        $this->addSql('ALTER TABLE professionelle CHANGE competence_id candidat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE professionelle ADD CONSTRAINT FK_A7CFF3848D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('CREATE INDEX IDX_A7CFF3848D0EB82 ON professionelle (candidat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personelle DROP FOREIGN KEY FK_56C785F48D0EB82');
        $this->addSql('DROP INDEX IDX_56C785F48D0EB82 ON personelle');
        $this->addSql('ALTER TABLE personelle CHANGE candidat_id competence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personelle ADD CONSTRAINT FK_56C785F415761DAB FOREIGN KEY (competence_id) REFERENCES candidat (id)');
        $this->addSql('CREATE INDEX IDX_56C785F415761DAB ON personelle (competence_id)');
        $this->addSql('ALTER TABLE professionelle DROP FOREIGN KEY FK_A7CFF3848D0EB82');
        $this->addSql('DROP INDEX IDX_A7CFF3848D0EB82 ON professionelle');
        $this->addSql('ALTER TABLE professionelle CHANGE candidat_id competence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE professionelle ADD CONSTRAINT FK_A7CFF38415761DAB FOREIGN KEY (competence_id) REFERENCES candidat (id)');
        $this->addSql('CREATE INDEX IDX_A7CFF38415761DAB ON professionelle (competence_id)');
    }
}
