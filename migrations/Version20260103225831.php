<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260103225831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add timestamps to Question Entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE question ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('UPDATE question SET created_at = COALESCE(asked_at, NOW()), updated_at = COALESCE(asked_at, NOW()) WHERE created_at IS NULL');
        $this->addSql('ALTER TABLE question MODIFY created_at DATETIME NOT NULL, MODIFY updated_at DATETIME NOT NULL');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE question DROP created_at, DROP updated_at');
    }
}
