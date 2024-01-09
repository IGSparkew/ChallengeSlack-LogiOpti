<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthenticationService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $userPasswordHasher
){

    }
    public function login(string $email, string $password){
        if(!empty($email) && !empty($password)){
            $userFound = $this->userRepository->findOneBy(['email' => $email]);
            $cleanPassword= trim($userFound->getPassword());
            if($userFound != null){
                if($this->userPasswordHasher->isPasswordValid($userFound,$cleanPassword)){
                   return "test";
                }
            }
        }
        return null ;
    }
}