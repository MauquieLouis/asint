<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210918170107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sport ADD responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sport ADD CONSTRAINT FK_1A85EFD253C59D72 FOREIGN KEY (responsable_id) REFERENCES membre (id)');
        $this->addSql('CREATE INDEX IDX_1A85EFD253C59D72 ON sport (responsable_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sport DROP FOREIGN KEY FK_1A85EFD253C59D72');
        $this->addSql('DROP INDEX IDX_1A85EFD253C59D72 ON sport');
        $this->addSql('ALTER TABLE sport DROP responsable_id');
    }
}
