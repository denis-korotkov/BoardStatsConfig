<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SignupController extends AbstractController
{
    #[Route('/signup', methods: ['GET'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

         return $this->render('auth/signup.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
         ]);
    }

    #[Route('/signup', name: 'signup', methods: ['POST'])]
    public function signup(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher, 
        EntityManagerInterface $entityManager
        ): RedirectResponse
    {
        $payload = $request->getPayload()->all();

        $user = new User();
        $user->setName($payload['username']);
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $payload['password']
        );
        $user->setPassword($hashedPassword);

        $role = $entityManager->getRepository(Role::class)->findOneBy(['role' => 'ROLE_USER']);
        $user->setRole($role);

        $entityManager->persist($user);
        $entityManager->flush();

        return new RedirectResponse("/");
    }
}
