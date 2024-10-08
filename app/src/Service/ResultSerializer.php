<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\Result;
use App\Repository\GameRepository;
use App\Repository\ResultRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ResultSerializer
{
    private readonly string $resultsPath;
    private readonly string $logPath;

    public function __construct(
        private readonly ResultRepository       $resultRepository,
        private readonly GameRepository         $gameRepository,
        private readonly SerializerInterface    $serializer,
        private readonly Filesystem             $filesystem,
        private readonly LoggerInterface        $logger,
        private readonly KernelInterface        $appKernel,
        private readonly EntityManagerInterface $entityManager,
        private readonly FieldValidatorService  $fieldValidatorService,
    )
    {
        $this->resultsPath = $this->appKernel->getLogDir() . "/results.json";
        $this->logPath = $this->appKernel->getLogDir() . "/" . date("m.d.y") . "/" . date("H:i:s") . ".json";
    }

    public function serialize(): bool
    {
        try {
            $results = $this->resultRepository->findAll();
            $jsonContent = $this->serializer->serialize($results, 'json', ['groups' => ['result']]);

            $this->filesystem->dumpFile($this->resultsPath, $jsonContent);
            $this->filesystem->dumpFile($this->logPath, $jsonContent);
        } catch (Exception $exception) {
            $this->logger->error($exception);
            return false;
        }
        return true;
    }

    public function deserialize(): bool
    {
        try {
            $jsonContent = file_get_contents($this->resultsPath);
            /** @var Result[] $results */
            $results = $this->serializer->deserialize($jsonContent, Result::class . '[]', 'json');
            $resultGameSlugs = array_map(fn(Result $result) => $result->getGame()->getSlug(), $results);

            $games = $this->gameRepository->findBySlug($resultGameSlugs);
            foreach ($results as $result) {
                $game = array_filter($games, fn(Game $game) => $game->getSlug() == $result->getGame()->getSlug());
                if (empty($game)) throw new Exception('Unknown game');

                $this->resultRepository->createFromArray($game[0], $this->entityManager, $this->fieldValidatorService, $result->getValue());
            }
        } catch (Exception $exception) {
            $this->logger->error($exception);
            return false;
        }
        return true;

    }

}
