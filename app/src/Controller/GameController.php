<?php

namespace App\Controller;

use App\Entity\Game;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game/{game}', methods: ['GET'])]
    public function get(Request $request, LoggerInterface $logger, Game $game): Response
    {
        return $this->render('game.twig', ['game' => $game->getName(), 'gameId' => $game->getId(), 'fields' => $game->getFields()->toArray(), 'results' => $game->getResults()->toArray()]);
    }
}
