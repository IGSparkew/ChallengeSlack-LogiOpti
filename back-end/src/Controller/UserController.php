<?php

namespace App\Controller;

use App\Entity\User;
use App\Middleware\AuthentificationMiddleware;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private AuthentificationMiddleware $authentificationMiddleware) { }

    #[Route('/api/user/role', name: 'app_role', methods: ["GET"])]
    public function getRole(Request $request): Response
    {
        if (!$this->authentificationMiddleware->verify($request)) {
            return $this->json(["error"=>"You are not connected or doesn't have token"],Response::HTTP_UNAUTHORIZED);
        }

        return $this->json(["role"=>$this->authentificationMiddleware->getRole($request)]);
    }

    #[Route('/api/user/get/{id}', name: 'app_get', methods: ["GET"])]
    public function get(Request $request, EntityManagerInterface $entityManager, int $id): jsonResponse
    {

        if (!$this->authentificationMiddleware->verify($request)) {
            return $this->json([
                'message' => 'You are not authentified or doesn\'t have the right to access this page'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $data = json_decode($request->getContent(), true);

        if (!empty($id)) {
            $user = $entityManager->getRepository(User::class)->find($id);
            if ($user) {
                $userObject = new User();
                return $this->json([$userObject->convertUserEntityToArray($user)]);
            }
            throw $this->createNotFoundException(
                'User not found' . $user
            );
        }
        return $this->json(['message' => "Missing Id"], 500);
    }
}

//CRUD complet