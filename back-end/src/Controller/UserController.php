<?php

namespace App\Controller;

use App\Entity\User;
use App\Middleware\AuthentificationMiddleware;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private AuthentificationMiddleware $authentificationMiddleware, private UserRepository $userRepository) { }

    #[Route('/api/user/role', name: 'app_role', methods: ["GET"])]
    public function getRole(Request $request): Response
    {
        if (!$this->authentificationMiddleware->verify($request)) {
            return $this->json(["error"=>"Your are not connected or doesn't have token"],Response::HTTP_UNAUTHORIZED);
        }

        return $this->json(["role"=>$this->authentificationMiddleware->getRole($request)]);
    }
}

//CRUD complet