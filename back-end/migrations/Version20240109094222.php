<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109094222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, toll_cost NUMERIC(10, 2) DEFAULT NULL, start_location VARCHAR(255) NOT NULL, end_location VARCHAR(255) NOT NULL, energy_cost NUMERIC(10, 2) DEFAULT NULL, using_cost NUMERIC(10, 2) DEFAULT NULL, distance NUMERIC(10, 2) DEFAULT NULL, time TIME DEFAULT NULL, payload VARCHAR(255) DEFAULT NULL, array_coordinates LONGTEXT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_3781EC10545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stats (id INT AUTO_INCREMENT NOT NULL, field_x VARCHAR(255) DEFAULT NULL, field_y VARCHAR(255) DEFAULT NULL, max_x VARCHAR(255) DEFAULT NULL, max_y VARCHAR(255) DEFAULT NULL, step_x VARCHAR(255) DEFAULT NULL, step_y VARCHAR(255) DEFAULT NULL, stats_values JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, max_load INT DEFAULT NULL, kilometer_cost NUMERIC(10, 2) DEFAULT NULL, average_comsumption NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10545317D1');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE stats');
        $this->addSql('DROP TABLE vehicle');
    }
}
