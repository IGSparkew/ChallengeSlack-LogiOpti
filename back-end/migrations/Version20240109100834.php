<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109100834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO `vehicle` (`id`, `type`, `max_load`, `kilometer_cost`, `average_comsumption`) VALUES
        (1, 'EUR_TRAILER_TRUCK', 25000, '2.00', '35'),
        (2, 'EUR_TRUCK_40T', 25500, '2.00', '35'),
        (3, 'EUR_TRUCK_11_99T', 5000, '1.50', '25'),
        (4, 'EUR_TRUCK_7_49T', 3490, '1.30', '17.5'),
        (5, 'EUR_VAN', 1390, '1.20', '15'),
        (6, 'EUR_CAR', 370, '1.00', '10'),
        (7, 'USA_8_SEMITRAILER_5AXLE', 22680, '1.55', '44'),
        (8, 'USA_5_DELIVERY', 5480, '1.43', '34'),
        (9, 'USA_1_PICKUP', 721, '1.24', '12'),
        (10, 'AUS_HR_HEAVY_RIGID', 24400, '2.00', '30'),
        (11, 'AUS_MR_MEDIUM_RIGID', 5600, '1.20', '25'),
        (12, 'AUS_LCV_LIGHT_COMMERCIAL', 2000, '0.70', '12'),
        (13, 'IMEA_TRUCK_40T', 25500, '7.31', '35'),
        (14, 'IMEA_TRUCK_7_49T', 3490, '4.75', '17.5'),
        (15, 'IMEA_VAN', 1390, '4.39', '15'),
        (16, 'IMEA_CAR', 370, '3.65', '10')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE vehicle');

    }
}
