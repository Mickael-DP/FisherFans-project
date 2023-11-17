<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231117093219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boat ADD COLUMN description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE boat ADD COLUMN brand VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE boat ADD COLUMN manufacturing_year INTEGER NOT NULL');
        $this->addSql('ALTER TABLE boat ADD COLUMN photo_url VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE boat ADD COLUMN required_license_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE boat ADD COLUMN boat_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE boat ADD COLUMN equipment CLOB NOT NULL');
        $this->addSql('ALTER TABLE boat ADD COLUMN deposit_amount DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__boat AS SELECT id, name FROM boat');
        $this->addSql('DROP TABLE boat');
        $this->addSql('CREATE TABLE boat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO boat (id, name) SELECT id, name FROM __temp__boat');
        $this->addSql('DROP TABLE __temp__boat');
    }
}
