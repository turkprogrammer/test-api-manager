<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241124210454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE test (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
    , is_active BOOLEAN NOT NULL)');

        $this->addSql("INSERT INTO test (name, created_at, is_active) VALUES 
        ('Test Item 1', '2024-01-25 10:00:00', 1),
        ('Test Item 2', '2024-01-25 11:30:00', 1),
        ('Test Item 3', '2024-01-25 12:45:00', 0),
        ('Test Item 4', '2024-01-25 14:15:00', 1),
        ('Test Item 5', '2024-01-25 15:20:00', 0)
    ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE test');
    }
}
