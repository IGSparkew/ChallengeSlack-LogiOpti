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
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $data = json_decode($request->getContent(), true);
        if (!empty($data) &&
            $data["email"] != null &&
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
                'message' => 'User created'
            ], Response::HTTP_CREATED);
        }

        return $this->json([
            'message' => 'The form is incomplete or invalid'
        ], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/api/admin/update', name: 'app_update', methods: ["PATCH"])]
    public function update(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!empty($data) && $data["email"] != null) {
            $user = $entityManager->getRepository(User::class)->findOneBy(array("email" => $data["email"]));
            if ($user) {
                if(isset($data["password"])){
                    $plainPassword = $data["password"];
                    $hashedPassword = $this->passwordHasher->hashPassword(
                        $user,
                        $plainPassword
                    );
                    $user->setPassword($hashedPassword);
                }
                if(isset($data["salary"])){
                    $user->setSalary($data["salary"]);
                }
                $entityManager->flush();
                return $this->json([
                    'message' => 'User updated'
                ], Response::HTTP_OK);
            }
            throw $this->createNotFoundException(
                'User not found' . $user
            );
        }
        return $this->json([
            'message' => 'The form is incomplete or invalid'
        ], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/api/admin/delete', name: 'app_delete', methods: ["DELETE"])]
    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!empty($data) && $data["email"] != null) {
            $user = $entityManager->getRepository(User::class)->findOneBy(array("email" => $data["email"]));
            if ($user) {
                $entityManager->remove($user);
                $entityManager->flush();
                return $this->json([
                    'message' => 'User deleted'
                ], Response::HTTP_OK);
            }
            throw $this->createNotFoundException(
                'User not found' . $user
            );
        }
        return $this->json([
            'message' => 'The form is incomplete or invalid'
        ], Response::HTTP_BAD_REQUEST);
    }
}
