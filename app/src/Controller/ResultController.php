<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Result;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends AbstractController
{
    #[Route('/result/{game}', methods: ['POST'])]
    public function post(Request $request, LoggerInterface $logger, Game $game, EntityManagerInterface $entityManager): Response
    {
        $payload = $request->getPayload();

        //todo сервис для валидации и простваления значений по результатам

        $result = new Result();
        $result->setGame($game);
        $result->setValue([
            'Result' => $payload->get('Result'),
            'Date' => $payload->get('Date'),
            'Players' => $payload->get('Players'),
            'Duration' => $payload->get('Duration'),
        ]);

        $entityManager->persist($result);
        $entityManager->flush();

        return new RedirectResponse('/');
    }
}
