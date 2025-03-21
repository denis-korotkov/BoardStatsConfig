<?php

namespace App\Controller;

use App\Entity\Game;
use App\Service\FieldService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game/{game}', methods: ['GET'])]
    public function get(Request $request, Game $game, FieldService $fieldService): Response
    {
        return $this->render('game.twig', [
            'game' => $game->getName(),
            'gameId' => $game->getId(),
            'fields' => $fieldService->getFields($game),
            'results' => $game->getResults()->toArray()
        ]);
    }
}
