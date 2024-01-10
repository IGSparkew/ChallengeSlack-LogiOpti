<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserManagerController extends AbstractController
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }

    #[Route('/api/admin/create', name: 'app_create', methods: ["POST"])]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $data = json_decode($request->getContent(), true);
        if (!empty($data) &&
            $data["lastName"] != null &&
            $data["firstName"] != null &&
            $data["password"] != null &&
            $data["salary"] != null &&
            !empty($data["roles"])
        ) {
            $user->setEmail($data["email"]);
            $plainPassword = $data["password"];
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $plainPassword
            );
            $user->setPassword($hashedPassword);
            $user->setLastName($data["lastName"]);
            $user->setFirstName($data["firstName"]);
            $user->setRoles($data["roles"]);
            $user->setSalary($data["salary"]);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->json([
                'message' => 'L\'utilisateur a bien été enregistré dans la base de données'
            ], Response::HTTP_CREATED);
        }

        return $this->json([
            'message' => 'Le formulaire d\'inscription est incomplet ou contient des données invalides'
        ], Response::HTTP_BAD_REQUEST);
    }
}
