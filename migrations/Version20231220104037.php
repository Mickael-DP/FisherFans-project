<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220104037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, manufacturing_year INTEGER NOT NULL, photo_url VARCHAR(255) NOT NULL, required_license_type VARCHAR(255) NOT NULL, boat_type VARCHAR(255) NOT NULL, equipment CLOB NOT NULL --(DC2Type:array)
        , deposit_amount DOUBLE PRECISION NOT NULL, max_capacity INTEGER NOT NULL, propulsion_type VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, CONSTRAINT FK_D86E834A7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D86E834A7E3C61F9 ON boat (owner_id)');
        $this->addSql('CREATE TABLE fishing_log (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, fish_name VARCHAR(255) NOT NULL, photo_url VARCHAR(255) NOT NULL, comment VARCHAR(255) DEFAULT NULL, size_cm DOUBLE PRECISION NOT NULL, weight_kg DOUBLE PRECISION NOT NULL, fishing_location VARCHAR(255) NOT NULL, fishing_date DATETIME NOT NULL, fish_released VARCHAR(255) NOT NULL, CONSTRAINT FK_D0E6E4517E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D0E6E4517E3C61F9 ON fishing_log (owner_id)');
        $this->addSql('CREATE TABLE fishing_trip (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, informations CLOB NOT NULL, type VARCHAR(255) NOT NULL, rate VARCHAR(255) NOT NULL, starting_date DATE NOT NULL, ending_date DATE NOT NULL, starting_time TIME NOT NULL, ending_time TIME NOT NULL, passenger_number INTEGER NOT NULL, price DOUBLE PRECISION NOT NULL, CONSTRAINT FK_816B7BEA7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_816B7BEA7E3C61F9 ON fishing_trip (owner_id)');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fishing_trip_id INTEGER DEFAULT NULL, owner_id INTEGER NOT NULL, date DATE NOT NULL, seat_number INTEGER NOT NULL, total_price DOUBLE PRECISION NOT NULL, CONSTRAINT FK_42C84955D49F882A FOREIGN KEY (fishing_trip_id) REFERENCES fishing_trip (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_42C849557E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_42C84955D49F882A ON reservation (fishing_trip_id)');
        $this->addSql('CREATE INDEX IDX_42C849557E3C61F9 ON reservation (owner_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, phone VARCHAR(50) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(20) NOT NULL, city VARCHAR(255) NOT NULL, languages_spoken CLOB DEFAULT NULL --(DC2Type:array)
        , avatar_url VARCHAR(255) DEFAULT NULL, boating_license_number VARCHAR(255) DEFAULT NULL, insurance_number VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, company_name VARCHAR(255) DEFAULT NULL, activity_type VARCHAR(255) DEFAULT NULL, siret_number VARCHAR(255) DEFAULT NULL, commerce_register_number VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE boat');
        $this->addSql('DROP TABLE fishing_log');
        $this->addSql('DROP TABLE fishing_trip');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
    }
}
