<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711080314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD commercial_id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404557854071C FOREIGN KEY (commercial_id) REFERENCES commercial (id)');
        $this->addSql('CREATE INDEX IDX_C74404557854071C ON client (commercial_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404557854071C');
        $this->addSql('DROP INDEX IDX_C74404557854071C ON client');
        $this->addSql('ALTER TABLE client DROP commercial_id');
    }
}
