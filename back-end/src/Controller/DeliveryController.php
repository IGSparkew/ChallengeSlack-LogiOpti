<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Delivery;
use App\Entity\DeliveryAddress;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Entity\VehicleType;
use DateInterval;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/delivery', name: 'api_')]
class DeliveryController extends AbstractController
{
    const UPCOMING = 0;
    const STATUS_END = 1;

    #[Route('/add', name: 'delivery_create', methods: ['post'])]
    public function create(ManagerRegistry $doctrine, Request $request, #[CurrentUser] ?User $user): JsonResponse
    {
        $dotenv = new Dotenv();
        $dotenv->load('../.env');
        $geoApiUrl = 'https://api.opencagedata.com/geocode/v1/json?key=d030bd453deb4ee0b589b32474216bf0&q=';
        $urlDelivery = 'https://api.myptv.com/routing/v1/routes?';
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);
        $vehicleType = $doctrine->getRepository(VehicleType::class)->find($data['id_vehicule']);
        
        $vehicle = new Vehicle();
        $vehicle->setVehicleType($vehicleType);
        $vehicle->addUser($user);
        $entityManager->persist($vehicle);
        
        $addressStart = new Address();
        $addressStart->setCountry($data['start_country']);
        $addressStart->setRegion($data['start_region']);
        $addressStart->setCity($data['start_city']);
        $addressStart->setStreet($data['start_street']);
        $addressStart->setPostalCode($data['start_postal_code']);
        $entityManager->persist($addressStart);
        
        $addressEnd = new Address();
        $addressEnd->setCountry($data['end_country']);
        $addressEnd->setRegion($data['end_region']);
        $addressEnd->setCity($data['end_city']);
        $addressEnd->setStreet($data['end_street']);
        $addressEnd->setPostalCode($data['end_postal_code']);
        $entityManager->persist($addressEnd);
        
        $deliveryAddress = new DeliveryAddress();
        $deliveryAddress->setAddressEnd($addressEnd);
        $deliveryAddress->setAddressStart($addressStart);
        
        $delivery = new Delivery();
        $dateDepart = new \DateTime($data['date_depart']);
        $delivery->setStartDate($dateDepart);


        $urlDepart = $geoApiUrl . urlencode($addressStart->getStreet() . ' ' . $addressStart->getCity() . ' ' . $addressStart->getCountry());
        $clientDepart = new Client();
        $responseDepart = json_decode(($clientDepart->request('GET', $urlDepart))->getBody(), true);
        $latitudeDepart = $responseDepart['results'][0]['geometry']['lat'];
        $longitudeDepart = $responseDepart['results'][0]['geometry']['lng'];

        $urlArrivee = $geoApiUrl . urlencode($addressEnd->getStreet() . ' ' . $addressEnd->getCity() . ' ' . $addressEnd->getCountry());
        $clientArrivee = new Client();
        $responseArrivee = json_decode(($clientArrivee->request('GET', $urlArrivee))->getBody(), true);
        $latitudeArrivee = $responseArrivee['results'][0]['geometry']['lat'];
        $longitudeArrivee = $responseArrivee['results'][0]['geometry']['lng'];

        $params = [
            'waypointsDepart' => $latitudeDepart . ","  . $longitudeDepart,
            'waypointsArrivee' => $latitudeArrivee . ","  . $longitudeArrivee,
            'vehicle[engineType]' => "HYBRID",
            'vehicle[hybridRatio]' => 50,
            'vehicle[electricityType]' => "BATTERY",
            'vehicle[averageElectricityConsumption]' => 100,
            'options[currency]' => "EUR",
            'monetaryCostOptions[costPerKilometer]' => $vehicleType->getKilometerCost(),
            'monetaryCostOptions[workingCostPerHour]' => $user->getSalary() ?? 20,
            'monetaryCostOptions[costPerFuelUnit]' => 1.75,
            'results' => "POLYLINE,MONETARY_COSTS",
            'options[routingMode]' => "MONETARY",
            'profile' => $vehicleType->getType(),
        ];
        
        foreach ($params as $key => $value) {
            if (stristr($key, 'waypoints')) {
                $urlDelivery .= 'waypoints=' . $value . '&';
            } else {
                $urlDelivery .= $key . '=' . $value . '&';
            }
        }
        $urlDelivery = substr($urlDelivery, 0, strlen($urlDelivery) - 1);
        
        $ch = curl_init($urlDelivery);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['ApiKey: ' . $_ENV['APIKEY']]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $deliveryResult = json_decode(curl_exec($ch), true);

        $coordinatesTab = json_decode($deliveryResult['polyline'], true);
        $coordinates = $coordinatesTab['coordinates'];

        $endDateProvisional = $dateDepart->add(new DateInterval('PT' . $deliveryResult['travelTime'] . 'S'));

        // ENREGISTREMENT DE LA DELIVERY EN BASE
        $delivery->setDistance($deliveryResult['distance']);
        $delivery->setTime($deliveryResult['travelTime']);
        $delivery->setEnergyCost($deliveryResult['monetaryCosts']['energyCost']);
        $delivery->setTollCost($deliveryResult['monetaryCosts']['tollCost']);
        $delivery->setUsingCost($deliveryResult['monetaryCosts']['distanceCost']);
        $delivery->setWorkingTimeCost($deliveryResult['monetaryCosts']['workingTimeCost']);
        $delivery->setArrayCoordinates(json_encode(array_map('array_reverse', $coordinates)));
        $delivery->setEndDate($endDateProvisional);
        $delivery->setStatus(self::UPCOMING);
        $delivery->setVehicle($vehicle);
        $delivery->setUser($user);
        
        $deliveryAddress->setDelivery($delivery);
        $entityManager->persist($deliveryAddress);
        $entityManager->persist($delivery);

        
        
        $entityManager->flush();
        return $this->json($delivery->convertDeliveryEntityToJson($doctrine->getRepository(Delivery::class)->find($delivery->getId())));
    }
}


//CRUD complet
