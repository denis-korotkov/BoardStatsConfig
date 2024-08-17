<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\ResultRepository;
use App\Service\FieldValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends AbstractController
{
    #[Route('/result/{game}', methods: ['GET'])]
    public function show(Game $game): Response
    {
        return $this->render('result.twig', ['game'=> $game->getId(), 'fields' => $game->getFields()]);
    }

    #[Route('/result/{game}', methods: ['POST'])]
    public function post(Request $request, ResultRepository $resultRepository, Game $game, EntityManagerInterface $entityManager, FieldValidatorService $fieldValidatorService): Response
    {
        $payload = $request->getPayload()->all();
        $resultRepository->create($game, $entityManager, $fieldValidatorService, $payload);

        return new RedirectResponse("/game/{$game->getId()}");
    }
}
