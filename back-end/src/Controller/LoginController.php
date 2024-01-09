<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\AuthenticationService;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ["POST"])]
    public function login(#[CurrentUser] ?User $user): Response
    {
        if ($user == null) {
            return $this->json([
                'message'=>'no user found'
            ],Response::HTTP_UNAUTHORIZED);
        }

        $token = "test";
        return $this->json([
            'user' => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }

}
