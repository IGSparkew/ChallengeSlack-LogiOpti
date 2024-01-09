<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\Vehicle;
use DateInterval;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use PhpParser\JsonDecoder;
use Symfony\Component\Dotenv\Dotenv;

#[Route('/api/delivery', name: 'api_')]
class DeliveryController extends AbstractController
{
    #[Route('/add', name: 'delivery_create', methods: ['post'])]
    public function create(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $dotenv = new Dotenv();
        $dotenv->load('../.env');

        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        $delivery = new Delivery();
        $dateDepart = new \DateTime($data['date_depart']);
        $delivery->setStartDate($dateDepart);
        $delivery->setPayload(($data['charge_vehicule']));
        $delivery->setEndLocation(($data['arrivee']));
        $delivery->setStartLocation(($data['depart']));
        $vehicle = $doctrine->getRepository(Vehicle::class)->find($data['id_vehicule']);
        $delivery->setVehicle($vehicle);

        $adresseDepart = $data['depart'];
        $adresseArrivee = $data['arrivee'];

        $urlDepart = 'https://api-adresse.data.gouv.fr/search/?q=' . urlencode($adresseDepart);
        $clientDepart = new Client();
        $responseDepart = json_decode(($clientDepart->request('GET', $urlDepart))->getBody(), true);
        $latitudeDepart = $responseDepart['features'][0]['geometry']['coordinates'][1];
        $longitudeDepart = $responseDepart['features'][0]['geometry']['coordinates'][0];

        $urlArrivee = 'https://api-adresse.data.gouv.fr/search/?q=' . urlencode($adresseArrivee);
        $clientArrivee = new Client();
        $responseArrivee = json_decode(($clientArrivee->request('GET', $urlArrivee))->getBody(), true);
        $latitudeArrivee = $responseArrivee['features'][0]['geometry']['coordinates'][1];
        $longitudeArrivee = $responseArrivee['features'][0]['geometry']['coordinates'][0];

        $urlDelivery = 'https://api.myptv.com/routing/v1/routes?';
        $params = [
            'query' => [
                'vehicle[engineType]' => "HYBRID",
                'vehicle[hybridRatio]' => 50,
                'vehicle[electricityType]' => "BATTERY",
                'vehicle[averageElectricityConsumption]' => 100,
                'options[currency]' => "EUR",
                'monetaryCostOptions[costPerKilometer]' => $vehicle->getKilometerCost(),
                // ICI IL FAUDRA RAJOUTER LE COUT HORAIRE DU USER
                'monetaryCostOptions[workingCostPerHour]' => 20.5,
                'waypoints' => $latitudeDepart . ","  . $longitudeDepart,
                'waypoints' => $latitudeArrivee . ","  . $longitudeArrivee,
                'monetaryCostOptions[costPerFuelUnit]' => 1.75,
                'results' => "POLYLINE,MONETARY_COSTS",
                'options[routingMode]' => "MONETARY",
                'profile' => $vehicle->getType(),
            ],
            'headers' => [
                'ApiKey' => $_ENV['APIKEY'], // Remplacez YOUR_ACCESS_TOKEN par le vrai jeton d'accès
            ],
        ];
        $clientDelivery = new Client();
        $deliveryResult = json_decode(($clientDelivery->request('GET', $urlDelivery, $params))->getBody(), true);

        // A DECOMMENTER LORSQUE L'AUTHENTIFICATION SERA FAITE
        // $workingTimeCost = $coutHoraireUser * ($deliveryResult['travelTime'] / 3600);

        // Récupération des coordonnées du trajets
        $coordinatesTab = json_decode($deliveryResult['polyline'], true);
        $coordinates = $coordinatesTab['coordinates'];

        // Calcul de la date d'arrivée provisoire
        $endDateProvisional = $dateDepart->add(new DateInterval('PT' . $deliveryResult['travelTime'] . 'S'));

        // ENREGISTREMENT DE LA DELIVERY EN BASE
        $delivery->setDistance($deliveryResult['distance']);
        $delivery->setTime($deliveryResult['travelTime']);
        $delivery->setEnergyCost($deliveryResult['monetaryCosts']['energyCost']);
        $delivery->setTollCost($deliveryResult['monetaryCosts']['tollCost']);
        $delivery->setUsingCost($deliveryResult['monetaryCosts']['distanceCost']);
        // A DECOMMENTER LORSQUE L'AUTHENTIFICATION SERA FAITE
        // $delivery->setWorkingTimeCost($workingTimeCost);
        $delivery->setArrayCoordinates(json_encode(array_map('array_reverse', $coordinates)));
        $delivery->setEndDate($endDateProvisional);
        $delivery->setStatus("Upcoming");

        dd($delivery);
        $entityManager->flush();


        // return $this->json(['delivery' => $delivery, 'WorkingTimeCost' => $workingTimeCost]);
        return $this->json($delivery);
    }
}
