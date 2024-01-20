<?php

namespace App\Controller;

use App\Repository\GameRepository;
use GameDTO;
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

    #[Route('/admin', methods: ['POST'])]
    public function post(Request $request): Response
    {
        $payload = $request->getPayload()->all();
        $game = GameDTO::factory();
        return new RedirectResponse('/admin');
    }
}