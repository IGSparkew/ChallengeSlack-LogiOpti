<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Delivery;
use App\Entity\DeliveryAddress;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Entity\VehicleType;
use DateInterval;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/delivery', name: 'api_')]
class DeliveryController extends AbstractController
{
    const UPCOMING = 0;
    const STATUS_PENDING = 1;
    const STATUS_END = 2;

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
        if ($entityManager->contains($delivery) && $entityManager->contains($deliveryAddress) && $entityManager->contains($addressEnd) && $entityManager->contains($addressStart) && $entityManager->contains($vehicle)) {
            return new JsonResponse(['message' => 'Le trajet a été enregistré !'], 200);
        } else {
            return new JsonResponse(['error' => 'Une erreur s\'est produite lors de l\'enregistrement en base de données.'], 500);
        }
    }

    #[Route('/get/{id}', name: 'delivery_get', methods: ['get'])]
    public function get(ManagerRegistry $doctrine, int $id, Request $request): JsonResponse
    {
        $delivery = $doctrine->getRepository(Delivery::class)->find($id);
        if (empty($delivery)) {
            return new JsonResponse(['message' => 'Trajet non trouvé'], 404);
        }
        return $this->json($delivery->convertDeliveryEntityToArray($delivery, $doctrine));
    }

    #[Route('/get', name: 'delivery_get_all', methods: ['get'])]
    public function getAll(ManagerRegistry $doctrine): JsonResponse
    {
        $deliveries = $doctrine->getRepository(Delivery::class)->findAll();
        if (empty($deliveries)) {
            return new JsonResponse(['message' => 'Aucun trajet trouvé'], 404);
        }
        $result = [];
        foreach ($deliveries as $delivery) {
            array_push($result, $delivery->convertDeliveryEntityToArray($delivery, $doctrine));
        }
        return $this->json($result);
    }

    #[Route('/delete/{id}', name: 'delivery_delete', methods: ['delete'])]
    public function delete(ManagerRegistry $doctrine, int $id, Request $request): JsonResponse
    {
        $delivery = $doctrine->getRepository(Delivery::class)->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($delivery);
        $entityManager->flush();
        if ($entityManager->contains($delivery)) {
            return new JsonResponse(['message' => 'Le trajet a été supprimé !'], 200);
        } else {
            return new JsonResponse(['error' => 'Une erreur s\'est produite lors de la suppression en base de données.'], 500);
        }
    }

    #[Route('/end/{id}', name: 'delivery_end', methods: ['put'])]
    public function endDelivery(ManagerRegistry $doctrine, int $id, Request $request): JsonResponse
    {
        $delivery = $doctrine->getRepository(Delivery::class)->find($id);
        $entityManager = $doctrine->getManager();
        $delivery->setEndDate(new DateTime());
        $delivery->setStatus(self::STATUS_END);
        $entityManager->persist($delivery);
        $entityManager->flush();
        return new JsonResponse(['message' => 'OK'], 200);
    }
}