<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game/{game}', methods: ['GET'])]
    public function show(Game $game)
    {
        return $this->render('game.twig', ['fields' => $game->getFields()]);
    }
}