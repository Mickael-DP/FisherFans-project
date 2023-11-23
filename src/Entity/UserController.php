<?php

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserPasswordHasherInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    private $passwordHasher;

    // Symfony 5.3 et versions ultérieures
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    // Pour les versions antérieures à Symfony 5.3, utilisez UserPasswordEncoderInterface
    // public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    // {
    //     $this->passwordEncoder = $passwordEncoder;
    // }

    public function register(Request $request): Response
    {
        // Création d'un nouvel utilisateur ou récupération d'un utilisateur existant
        $user = new User();
        $data = json_decode($request->getContent(), true);

        // Hacher le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $data['password']
        );

        // Définir le mot de passe haché
        $user->setPassword($hashedPassword);

        // Enregistrez l'utilisateur en base de données
        // ...

        return new Response('Utilisateur enregistré', Response::HTTP_CREATED);
    }
}
