<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231125100616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fishing_trip_id INTEGER DEFAULT NULL, date DATE NOT NULL, seat_number INTEGER NOT NULL, total_price DOUBLE PRECISION NOT NULL, CONSTRAINT FK_42C84955D49F882A FOREIGN KEY (fishing_trip_id) REFERENCES fishing_trip (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_42C84955D49F882A ON reservation (fishing_trip_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, phone VARCHAR(50) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(20) NOT NULL, city VARCHAR(255) NOT NULL, languages_spoken CLOB DEFAULT NULL --(DC2Type:array)
        , avatar_url VARCHAR(255) DEFAULT NULL, boating_license_number VARCHAR(255) DEFAULT NULL, insurance_number VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, company_name VARCHAR(255) DEFAULT NULL, activity_type VARCHAR(255) DEFAULT NULL, siret_number VARCHAR(255) DEFAULT NULL, commerce_register_number VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
    }
}
