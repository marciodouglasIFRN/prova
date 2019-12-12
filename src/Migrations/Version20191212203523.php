<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191212203523 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE log (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('ALTER TABLE aluno ADD COLUMN log_id INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE projeto ADD COLUMN log_id INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE log');
        $this->addSql('CREATE TEMPORARY TABLE __temp__aluno AS SELECT id, nome, projeto_id FROM aluno');
        $this->addSql('DROP TABLE aluno');
        $this->addSql('CREATE TABLE aluno (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, projeto_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO aluno (id, nome, projeto_id) SELECT id, nome, projeto_id FROM __temp__aluno');
        $this->addSql('DROP TABLE __temp__aluno');
        $this->addSql('CREATE TEMPORARY TABLE __temp__projeto AS SELECT id, nome, status, orientador_id FROM projeto');
        $this->addSql('DROP TABLE projeto');
        $this->addSql('CREATE TABLE projeto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, status BOOLEAN DEFAULT NULL, orientador_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO projeto (id, nome, status, orientador_id) SELECT id, nome, status, orientador_id FROM __temp__projeto');
        $this->addSql('DROP TABLE __temp__projeto');
    }
}
