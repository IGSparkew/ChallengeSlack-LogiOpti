<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\AuthenticationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;




class LoginController extends AbstractController
{

    public function __construct(private UserRepository $userRepository, private UserPasswordHasherInterface $userPasswordHasherInterface, private JWTTokenManagerInterface $JWTManager) { }

    #[Route('/login', name: 'login', methods: ["POST"])]
    public function login(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($data == null) {
            return $this->json("body not found",Response::HTTP_UNAUTHORIZED);
        }

        $email = $data["username"];
        $password = $data["password"];

        if (empty($email) || empty($password)) {
            return $this->json("body not found",Response::HTTP_UNAUTHORIZED);
        }

        $userFound = $this->userRepository->findOneBy(["email" => $email]);

        if ($userFound == null) {
            return $this->json("user not found",Response::HTTP_UNAUTHORIZED);
        }

        if ($this->userPasswordHasherInterface->isPasswordValid($userFound, trim($password))) {
            return $this->json($this->JWTManager->create($userFound));
        }

        return $this->json("password not correct",Response::HTTP_UNAUTHORIZED);
    }

}
