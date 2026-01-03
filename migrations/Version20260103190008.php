<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260103190008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add votes counter to Question entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE question ADD votes INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE question DROP votes');
    }
}
