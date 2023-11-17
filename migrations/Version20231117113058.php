<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231117113058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fishing_trip (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, informations CLOB NOT NULL, type VARCHAR(255) NOT NULL, rate VARCHAR(255) NOT NULL, starting_date DATE NOT NULL, ending_date DATE NOT NULL, starting_time TIME NOT NULL, ending_time TIME NOT NULL, passenger_number INTEGER NOT NULL, price DOUBLE PRECISION NOT NULL)');
        $this->addSql('DROP TABLE reservation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL, seat_number INTEGER NOT NULL, total_price DOUBLE PRECISION NOT NULL)');
        $this->addSql('DROP TABLE fishing_trip');
    }
}
