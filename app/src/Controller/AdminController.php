<?php

namespace App\Controller;

use App\Dto\GameGto;
use App\Entity\Game;
use App\Entity\Result;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', methods: ['GET'])]
    public function index(GameRepository $gameRepository): Response
    {
        $games = $gameRepository->findAll();
        return $this->render('admin.twig', ['games' => $games]);
    }

    #[Route('/admin/{game}', methods: ['POST'])]
    public function post(Request $request, LoggerInterface $logger, Game $game, EntityManagerInterface $entityManager): Response
    {
        $payload = $request->getPayload();

        $gameDto = new GameGto(
            $payload->get('Result'),
            $payload->get('Date'),
            $payload->get('Players'),
            $payload->get('Duration'),
        );


        $result = new Result();
        $result->setGame($game);
        $result->setValue([
            'result' => $gameDto->result,
            'date' => $gameDto->date,
            'players' => $gameDto->players,
            'duration' => $gameDto->date,
        ]);


        $entityManager->persist($result);
        $entityManager->flush();

        return new RedirectResponse('/admin');
    }
}
