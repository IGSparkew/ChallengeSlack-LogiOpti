<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends AbstractController
{
    public function __construct() { }

    #[Route('/api/user/role', name: 'app_role', methods: ["GET"])]
    public function getRole(#[CurrentUser] ?User $user): Response
    {
        if($user == null){
            return $this->json(["message"=>"User not found"], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json(["role"=>$user->getRoles()]);
    }
}
