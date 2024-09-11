<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\ResultRepository;
use App\Service\FieldValidatorService;
use App\Service\ResultSerializer;
use App\Service\FieldService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends AbstractController
{
    #[Route('/result/{game}', methods: ['GET'])]
    public function show(Game $game, FieldService $fieldService): Response
    {
        $fields = $fieldService->getFields($game);
        return $this->render('result.twig', ['game'=> $game->getId(), 'fields' => $fields]);
    }

    #[Route('/result/{game}', methods: ['POST'])]
    public function post(Request $request, ResultRepository $resultRepository, Game $game, EntityManagerInterface $entityManager, FieldValidatorService $fieldValidatorService): Response
    {
        $payload = $request->getPayload()->all();
        $resultRepository->createFromArray($game, $entityManager, $fieldValidatorService, $payload);

        return new RedirectResponse("/game/{$game->getId()}");
    }

    #[Route('/admin/deserialize', methods: ['POST'])]
    public function deserialize(ResultSerializer $resultSerializer): Response
    {
        $resultSerializer->deserialize();

        return new Response("deserialized");
    }

    #[Route('/admin/serialize', methods: ['POST'])]
    public function serialize(ResultSerializer $resultSerializer): Response
    {
        $resultSerializer->serialize();

        return new Response("serialized");
    }
}
