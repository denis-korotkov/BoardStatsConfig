<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    #[Route('/my-games', methods: ['GET'])]
    public function get(Request $request, UserInterface $user): Response
    {
        $player = $user->getPlayer();
        return $this->render('game.twig', [
            'games' => $player->getGames(),
        ]);
    }
}
