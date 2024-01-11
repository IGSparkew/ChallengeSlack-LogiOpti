<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\VehicleType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/statistics', name: 'api_')]
class StatisticsController extends AbstractController
{

    private $prixEssence = 1.75;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/getDaylyToTal/{year}-{month}-{day}/{timeChoice}/{typeChoix}/{truckType?}', name: 'dayly_total_get', methods: ['get'])]
    public function getDaylyStats(ManagerRegistry $doctrine, Request $request, $year, $month, $day, $timeChoice, $typeChoix, $truckType): JsonResponse
    {
        // $entityManager = $doctrine->getManager();
        $deliveries = [];
        $result = [];
        $prixEssenceTotal = 0.00;
        $volumeEssenceTotal = 0.00;
        $coutUsureTotal = 0.00;
        $startDate = $this->convertStartDate($timeChoice, $year, $month, $day);
        $endDate = $this->convertEndDate($timeChoice, $year, $month, $day);

        switch ($typeChoix) {
            case "trajet":
                $deliveryRepository = $this->entityManager->getRepository(Delivery::class);
                $deliveriesResult = $deliveryRepository->findBetweenDate($startDate, $endDate);
                foreach ($deliveriesResult as $deliveryResult) {

                    $prixEssenceVehicle = $deliveryResult->getEnergyCost();
                    // Ajout au cout essence total
                    $prixEssenceTotal += $prixEssenceVehicle;
                    $volumeEssenceVehicle = $prixEssenceVehicle / $this->prixEssence;
                    // Ajout au volume essence total
                    $volumeEssenceTotal += $volumeEssenceVehicle;
                    // Ajout au cout usure total
                    $coutUsureTotal += $deliveryResult->getUsingCost();
                    $deliveryDTO = $deliveryResult->convertDeliveryEntityToArray($deliveryResult, $doctrine);
                    $deliveryDTO["fuelVolume"] = $volumeEssenceVehicle;
                    array_push($deliveries, $deliveryDTO);
                }

                $result = [
                    "livraisons" => $deliveries,
                    "cout_totaux" => [
                        "cout_essence_total" => $prixEssenceTotal,
                        "volume_essence_total" => $volumeEssenceTotal,
                        "cout_usure_total" => $coutUsureTotal
                    ]
                ];

                return new JsonResponse([$result], 200);
                break;

            case "truck":

                $truckTypeToCheck = $doctrine->getRepository(VehicleType::class)->findOneBy(['type' => $truckType]);
                if ($truckTypeToCheck == null) {
                    return new JsonResponse(['message' => 'Le type de camion selectionné n\'existe pas'], 400);
                } else {
                    $deliveryRepository = $this->entityManager->getRepository(Delivery::class);
                    $deliveriesResult = $deliveryRepository->findBetweenDateAndTruckType($startDate, $endDate, $truckType);

                    foreach ($deliveriesResult as $deliveryResult) {

                        $prixEssenceVehicle = $deliveryResult->getEnergyCost();
                        // Ajout au cout essence total
                        $prixEssenceTotal += $prixEssenceVehicle;
                        $volumeEssenceVehicle = $prixEssenceVehicle / $this->prixEssence;
                        // Ajout au volume essence total
                        $volumeEssenceTotal += $volumeEssenceVehicle;
                        // Ajout au cout usure total
                        $coutUsureTotal += $deliveryResult->getUsingCost();

                        $deliveryDTO = $deliveryResult->convertDeliveryEntityToArray($deliveryResult, $doctrine);
                        // dd($deliveryDTO);
                        $deliveryDTO["fuelVolume"] = $volumeEssenceVehicle;
                        array_push($deliveries, $deliveryDTO);
                    }

                    $result = [
                        "livraisons" => $deliveries,
                        "cout_totaux" => [
                            "cout_essence_total" => $prixEssenceTotal,
                            "volume_essence_total" => $volumeEssenceTotal,
                            "cout_usure_total" => $coutUsureTotal
                        ]
                    ];

                    return new JsonResponse([$result], 200);
                    break;
                }
        }
    }


    private function convertStartDate($timeChoice, $year, $month, $day)
    {
        if ($timeChoice == "day") {
            $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $year . '-' . $month . '-' . $day . " 00:00:00");
        } elseif ($timeChoice == "month") {
            $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $year . '-' . $month . '-01' . " 00:00:00");
        } elseif ($timeChoice == "year") {
            $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $year . '-01' . '-01' . " 00:00:00");
        }
        return $startDate;
    }

    private function convertEndDate($timeChoice, $year, $month, $day)
    {
        if ($timeChoice == "day") {
            $endDate = DateTime::createFromFormat('Y-m-d H:i:s', $year . '-' . $month . '-' . $day . " 23:59:59");
        } elseif ($timeChoice == "month") {
            $endDate = DateTime::createFromFormat('Y-m-d H:i:s', $year . '-' . $month . '-31' . " 23:59:59");
        } elseif ($timeChoice == "year") {
            $endDate = DateTime::createFromFormat('Y-m-d H:i:s', $year . '-12' . '-31' . " 23:59:59");
        }
        return $endDate;
    }
}

//CRUD complet