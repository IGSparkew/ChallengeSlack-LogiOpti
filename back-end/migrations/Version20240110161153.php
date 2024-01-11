<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240110161153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, postal_code VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT DEFAULT NULL, user_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, toll_cost NUMERIC(10, 2) DEFAULT NULL, energy_cost NUMERIC(10, 2) DEFAULT NULL, using_cost NUMERIC(10, 2) DEFAULT NULL, distance NUMERIC(10, 2) DEFAULT NULL, array_coordinates LONGTEXT DEFAULT NULL, working_time_cost NUMERIC(10, 2) DEFAULT NULL, time INT DEFAULT NULL, status INT DEFAULT NULL, INDEX IDX_3781EC10545317D1 (vehicle_id), INDEX IDX_3781EC10A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_address (id INT AUTO_INCREMENT NOT NULL, delivery_id INT DEFAULT NULL, address_start_id INT DEFAULT NULL, address_end_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_750D05F12136921 (delivery_id), INDEX IDX_750D05F9CB2071A (address_start_id), INDEX IDX_750D05FD9E40FAF (address_end_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, salary NUMERIC(5, 2) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, vehicle_type_id INT NOT NULL, INDEX IDX_1B80E486DA3FD1FC (vehicle_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_user (vehicle_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FF0EE515545317D1 (vehicle_id), INDEX IDX_FF0EE515A76ED395 (user_id), PRIMARY KEY(vehicle_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, kilometer_cost NUMERIC(10, 2) DEFAULT NULL, average_comsumption NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE delivery_address ADD CONSTRAINT FK_750D05F12136921 FOREIGN KEY (delivery_id) REFERENCES delivery (id)');
        $this->addSql('ALTER TABLE delivery_address ADD CONSTRAINT FK_750D05F9CB2071A FOREIGN KEY (address_start_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE delivery_address ADD CONSTRAINT FK_750D05FD9E40FAF FOREIGN KEY (address_end_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486DA3FD1FC FOREIGN KEY (vehicle_type_id) REFERENCES vehicle_type (id)');
        $this->addSql('ALTER TABLE vehicle_user ADD CONSTRAINT FK_FF0EE515545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicle_user ADD CONSTRAINT FK_FF0EE515A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql("INSERT INTO `vehicle_type` (`id`, `type`, `kilometer_cost`, `average_comsumption`) VALUES
        (1, 'EUR_TRAILER_TRUCK', '2.00', '35'),
        (2, 'EUR_TRUCK_40T', '2.00', '35'),
        (3, 'EUR_TRUCK_11_99T', '1.50', '25'),
        (4, 'EUR_TRUCK_7_49T', '1.30', '17.5'),
        (5, 'EUR_VAN', '1.20', '15'),
        (6, 'EUR_CAR', '1.00', '10'),
        (7, 'USA_8_SEMITRAILER_5AXLE', '1.55', '44'),
        (8, 'USA_5_DELIVERY', '1.43', '34'),
        (9, 'USA_1_PICKUP', '1.24', '12'),
        (10, 'AUS_HR_HEAVY_RIGID', '2.00', '30'),
        (11, 'AUS_MR_MEDIUM_RIGID', '1.20', '25'),
        (12, 'AUS_LCV_LIGHT_COMMERCIAL', '0.70', '12'),
        (13, 'IMEA_TRUCK_40T', '7.31', '35'),
        (14, 'IMEA_TRUCK_7_49T', '4.75', '17.5'),
        (15, 'IMEA_VAN', '4.39', '15'),
        (16, 'IMEA_CAR', '3.65', '10')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10545317D1');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10A76ED395');
        $this->addSql('ALTER TABLE delivery_address DROP FOREIGN KEY FK_750D05F12136921');
        $this->addSql('ALTER TABLE delivery_address DROP FOREIGN KEY FK_750D05F9CB2071A');
        $this->addSql('ALTER TABLE delivery_address DROP FOREIGN KEY FK_750D05FD9E40FAF');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486DA3FD1FC');
        $this->addSql('ALTER TABLE vehicle_user DROP FOREIGN KEY FK_FF0EE515545317D1');
        $this->addSql('ALTER TABLE vehicle_user DROP FOREIGN KEY FK_FF0EE515A76ED395');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE delivery_address');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE vehicle_user');
        $this->addSql('DROP TABLE vehicle_type');
    }
}
