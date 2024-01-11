<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ["POST"])]
    public function login(#[CurrentUser] ?User $user): Response
    {
        if ($user == null) {
            return $this->json([
                'message'=>'User not found'
            ],Response::HTTP_UNAUTHORIZED);
        }

        $token = "";
        return $this->json([
            'user' => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }

}
