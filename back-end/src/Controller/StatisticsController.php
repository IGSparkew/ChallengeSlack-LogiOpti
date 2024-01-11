<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Repository\DeliveryRepository;
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

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/getDaylyToTal/{year}-{month}-{day}', name: 'dayly_total_get', methods: ['get'])]
    public function get(ManagerRegistry $doctrine, Request $request, $year, $month, $day): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);


        $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $year . '-' . $month . '-' . $day . " 00:00:00");
        $endDate = DateTime::createFromFormat('Y-m-d H:i:s', $year . '-' . $month . '-' . $day . " 23:59:59");

        $deliveryRepository = $this->entityManager->getRepository(Delivery::class);

        $deliveries = $deliveryRepository->findBetweenDate($startDate, $endDate);

        dd($deliveries);

        $delivery = $doctrine->getRepository(Delivery::class)->find($request->query->get('id'));
        return $this->json($delivery->convertDeliveryEntityToArray($delivery, $doctrine));
    }
}

//CRUD complet