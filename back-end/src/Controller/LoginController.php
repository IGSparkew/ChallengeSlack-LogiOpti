<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\AuthenticationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{

    public function __construct(
        private AuthenticationService $authenticationService
    ){

    }

    #[Route('/login', name: 'app_login', methods: ["POST"])]
    public function login(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(),true);
        $email = $payload["email"];
        $password = $payload["password"];
        if(!empty($email) && !empty($password)){
           $result = $this->authenticationService->login($email, $password);
           return $this->json($result, 200);
        }
        return $this->json(["error"=>"error on authentication"],403);
    }

}
