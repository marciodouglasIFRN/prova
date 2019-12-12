<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191212184406 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE status (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('ALTER TABLE projeto ADD COLUMN status BOOLEAN DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE status');
        $this->addSql('CREATE TEMPORARY TABLE __temp__projeto AS SELECT id, nome, orientador_id FROM projeto');
        $this->addSql('DROP TABLE projeto');
        $this->addSql('CREATE TABLE projeto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, orientador_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO projeto (id, nome, orientador_id) SELECT id, nome, orientador_id FROM __temp__projeto');
        $this->addSql('DROP TABLE __temp__projeto');
    }
}
