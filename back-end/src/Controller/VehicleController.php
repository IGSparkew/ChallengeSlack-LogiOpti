<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vehicle;
use App\Entity\VehicleType;
use App\Middleware\AuthentificationMiddleware;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/api/vehicle', name: 'api_')]
class VehicleController extends AbstractController
{
    public function __construct(private AuthentificationMiddleware $authentificationMiddleware)
    {
    }

    #[Route('/add', name: 'vehicle_get', methods: ['post'])]
    public function add(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        if (!$this->authentificationMiddleware->checkIfUserDriver($request)) {
            return $this->json([
                'message' => 'You are not authentified or doesn\'t have the right to access this page'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $vehicle = new Vehicle();
        $datas = $request->getContent();
        if (!empty($datas['user_id']) && !empty($datas['vehicle_type_id'])) {
            $user = $doctrine->getRepository(User::class)->find($datas['user_id']);
            $vehicleType = $doctrine->getRepository(VehicleType::class)->find($datas['vehicle_type_id']);
            $vehicle->addUser($user);
            $vehicle->setVehicleType($vehicleType);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($vehicle);
            $entityManager->flush();
            if ($entityManager->contains($vehicle)) {
                return new JsonResponse(['message' => 'Le véhicule a été ajouté !'], 200);
            } else {
                return new JsonResponse(['error' => 'Une erreur s\'est produite lors de l\'ajout en base de données.'], 500);
            }
        }
        return $this->json($vehicle->convertVehicleEntityToArray($vehicle, $doctrine));
    }

    #[Route('/get/{id}', name: 'vehicle_get', methods: ['get'])]
    public function get(ManagerRegistry $doctrine, int $id, Request $request): JsonResponse
    {
        if (!$this->authentificationMiddleware->verify($request)) {
            return $this->json([
                'message' => 'You are not authentified or doesn\'t have the right to access this page'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $vehicle = $doctrine->getRepository(Vehicle::class)->find($id);
        if (empty($vehicle)) {
            return new JsonResponse(['message' => 'Véhicule non trouvé'], 404);
        }
        return $this->json($vehicle->convertVehicleEntityToArray($vehicle, $doctrine));
    }

    #[Route('/get', name: 'vehicle_get_all', methods: ['get'])]
    public function getAll(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        // if (!$this->authentificationMiddleware->verify($request)) {
        //     return $this->json([
        //         'message' => 'You are not authentified or doesn\'t have the right to access this page'
        //     ], Response::HTTP_UNAUTHORIZED);
        // }
        $vehicles = $doctrine->getRepository(Vehicle::class)->findAll();
        if (empty($vehicles)) {
            return new JsonResponse(['message' => 'Aucun véhicule trouvé'], 404);
        }
        $result = [];
        foreach ($vehicles as $vehicle) {
            array_push($result, $vehicle->convertVehicleEntityToArray($vehicle, $doctrine));
        }
        return $this->json($result);
    }

    #[Route('/delete/{id}', name: 'vehicle_delete', methods: ['delete'])]
    public function delete(ManagerRegistry $doctrine, int $id, Request $request): JsonResponse
    {
        if (!$this->authentificationMiddleware->checkIfUserOffice($request)) {
            return $this->json([
                'message' => 'You are not authentified or doesn\'t have the right to access this page'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $vehicle = $doctrine->getRepository(Vehicle::class)->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($vehicle);
        $entityManager->flush();
        if ($entityManager->contains($vehicle)) {
            return new JsonResponse(['message' => 'Le véhicule a été supprimé !'], 200);
        } else {
            return new JsonResponse(['error' => 'Une erreur s\'est produite lors de la suppression en base de données.'], 500);
        }
    }
}
