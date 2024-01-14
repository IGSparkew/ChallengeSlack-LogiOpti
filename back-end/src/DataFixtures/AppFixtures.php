<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Delivery;
use App\Entity\DeliveryAddress;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Entity\VehicleType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $address1 = new Address();
        $address1->setCountry('FR');
        $address1->setRegion('AURA');
        $address1->setCity('Lyon');
        $address1->setStreet('court albert thomas');
        $address1->setPostalCode('69003');
        $manager->persist($address1);

        $address2 = new Address();
        $address2->setCountry('FR');
        $address2->setRegion('NORMANDIE');
        $address2->setCity('ROUEN');
        $address2->setStreet('rue jeanne d\'arc');
        $address2->setPostalCode('76000');
        $manager->persist($address2);

        $address3 = new Address();
        $address3->setCountry('FR');
        $address3->setRegion('PARIS');
        $address3->setCity('Paris');
        $address3->setStreet('rue de la paix');
        $address3->setPostalCode('75000');
        $manager->persist($address3);

        $manager->flush();

        $data = [
            ['EUR_TRAILER_TRUCK', '2.00', '35'],
            ['EUR_TRUCK_40T', '2.00', '35'],
            ['EUR_TRUCK_11_99T', '1.50', '25'],
            ['EUR_TRUCK_7_49T', '1.30', '17.5'],
            ['EUR_VAN', '1.20', '15'],
            ['EUR_CAR', '1.00', '10'],
            ['USA_8_SEMITRAILER_5AXLE', '1.55', '44'],
            ['USA_5_DELIVERY', '1.43', '34'],
            ['USA_1_PICKUP', '1.24', '12'],
            ['AUS_HR_HEAVY_RIGID', '2.00', '30'],
            ['AUS_MR_MEDIUM_RIGID', '1.20', '25'],
            ['AUS_LCV_LIGHT_COMMERCIAL', '0.70', '12'],
            ['IMEA_TRUCK_40T', '7.31', '35'],
            ['IMEA_TRUCK_7_49T', '4.75', '17.5'],
            ['IMEA_VAN', '4.39', '15'],
            ['IMEA_CAR', '3.65', '10'],
        ];

        $vehicles = [];
        foreach ($data as $item) {
            $vehicleType = new VehicleType();
            $vehicleType->setType($item[0]);
            $vehicleType->setKilometerCost($item[1]);
            $vehicleType->setAverageComsumption($item[2]);

            $manager->persist($vehicleType);
            array_push($vehicles, $vehicleType);
        }
        $manager->flush();
        for ($j = 1; $j <= 20; $j++) {
            // Create a user
            $user1 = new User();
            $user1->setEmail('john' . $j . '@example.com');
            $user1->setRoles(['ROLE_DRIVER']);
            $user1->setLastName('Doe');
            $user1->setFirstName('John');
            $user1->setSalary('20.00');

            $hashedPassword = $this->passwordEncoder->hashPassword(
                $user1,
                'test'
            );
            $user1->setPassword($hashedPassword);
            $manager->persist($user1);

            $user2 = new User();
            $user2->setEmail('jane' . $j . '@example.com');
            $user2->setRoles(['ROLE_ADMIN']);
            $user2->setLastName('Doe');
            $user2->setFirstName('Jane');

            $hashedPassword = $this->passwordEncoder->hashPassword(
                $user2,
                'test'
            );
            $user2->setPassword($hashedPassword);
            $manager->persist($user2);

            $user3 = new User();
            $user3->setEmail('james' . $j . '@example.com');
            $user3->setRoles(['ROLE_DRIVER']);
            $user3->setLastName('BOND');
            $user3->setFirstName('James');
            $user3->setSalary('40.00');

            $hashedPassword = $this->passwordEncoder->hashPassword(
                $user3,
                'test'
            );
            $user3->setPassword($hashedPassword);
            $manager->persist($user3);

            $user4 = new User();
            $user4->setEmail('jeanne' . $j . '@example.com');
            $user4->setRoles(['ROLE_OFFICE']);
            $user4->setLastName('Calmant');
            $user4->setFirstName('Jeanne');
            $user4->setSalary('35.00');

            $hashedPassword = $this->passwordEncoder->hashPassword(
                $user4,
                'test'
            );
            $user4->setPassword($hashedPassword);
            $manager->persist($user4);
            $manager->flush();

            $vehicle1 = new Vehicle();
            $vehicle1->setVehicleType($vehicles[0]);
            $manager->persist($vehicle1);

            $vehicle2 = new Vehicle();
            $vehicle2->setVehicleType($vehicles[5]);
            $manager->persist($vehicle2);

            $vehicle3 = new Vehicle();
            $vehicle3->setVehicleType($vehicles[7]);
            $manager->persist($vehicle3);

            $vehicle4 = new Vehicle();
            $vehicle4->setVehicleType($vehicles[9]);
            $manager->persist($vehicle4);

            $manager->flush();

            $user1->addVehicle($vehicle1);
            $manager->persist($user1);

            $user2->addVehicle($vehicle2);
            $manager->persist($user2);

            $user3->addVehicle($vehicle3);
            $manager->persist($user3);

            $user4->addVehicle($vehicle4);
            $manager->persist($user4);

            $manager->flush();

            $deliveries = [];
            for ($i = 1; $i <= 10; $i++) {
                $delivery = new Delivery();
                $delivery
                    ->setStartDate(new \DateTime())
                    ->setEndDate(new \DateTime('+' . random_int(1, 3) . ' hour'))
                    ->setTollCost(10 * $i)
                    ->setEnergyCost(20 * $i)
                    ->setUsingCost(15 * $i)
                    ->setDistance(50 * $i)
                    ->setWorkingTimeCost(25 * $i)
                    ->setTime(120 * $i)
                    ->setStatus(array_rand(Delivery::Status))

                    ->setVehicle($i % 2 ? $vehicle2 : $vehicle1)
                    ->setUser($i % 2 ? $user1 : $user3);

                $manager->persist($delivery);
                array_push($deliveries, $delivery);
            }
            $manager->flush();

            foreach ($deliveries as $delivery) {
                $deliveryAddress = new DeliveryAddress();
                if ($delivery->getId() % 2) {
                    $deliveryAddress->setDelivery($delivery);
                    $deliveryAddress->setAddressStart($address1);
                    $deliveryAddress->setAddressEnd($address3);
                } else {
                    $deliveryAddress->setDelivery($delivery);
                    $deliveryAddress->setAddressStart($address3);
                    $deliveryAddress->setAddressEnd($address1);
                }
                $manager->persist($deliveryAddress);
            }
            $manager->flush();
        }
    }
}