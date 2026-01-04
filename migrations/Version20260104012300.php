<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260104012300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relations between Question and Answer entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE answer ADD question_id INT NOT NULL COMMENT \'id of question\'');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT fk_answer_question FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX answer_question_id_index ON answer (question_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY fk_answer_question');
        $this->addSql('DROP INDEX answer_question_id_index ON answer');
        $this->addSql('ALTER TABLE answer DROP question_id');
    }
}
