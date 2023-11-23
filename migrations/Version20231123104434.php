<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231123104434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, date, seat_number, total_price FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fishing_trip_id INTEGER DEFAULT NULL, date DATE NOT NULL, seat_number INTEGER NOT NULL, total_price DOUBLE PRECISION NOT NULL, CONSTRAINT FK_42C84955D49F882A FOREIGN KEY (fishing_trip_id) REFERENCES fishing_trip (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reservation (id, date, seat_number, total_price) SELECT id, date, seat_number, total_price FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE INDEX IDX_42C84955D49F882A ON reservation (fishing_trip_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, date, seat_number, total_price FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL, seat_number INTEGER NOT NULL, total_price DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO reservation (id, date, seat_number, total_price) SELECT id, date, seat_number, total_price FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
    }
}
