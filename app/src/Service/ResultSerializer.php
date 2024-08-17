<?php

namespace App\Service;

use App\Repository\ResultRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ResultSerializer
{
    private readonly string $path;

    public function __construct(
        private readonly ResultRepository $resultRepository,
        private readonly SerializerInterface $serializer,
        private readonly Filesystem $filesystem,
        private readonly LoggerInterface $logger,
        private readonly KernelInterface $appKernel,
    ){
        $this->path = $this->appKernel->getLogDir() . "/results.json";
    }

    public function serialize(): bool
    {
        try {
            $results = $this->resultRepository->findAll();
            $jsonContent = $this->serializer->serialize($results, 'json', ['groups' => ['result']]);

            $this->filesystem->dumpFile($this->path, $jsonContent);
        } catch (\Exception $exception){
            $this->logger->error($exception);
            return false;
        }
        return true;
    }

    public function deserialize(): bool{
        try {
            $jsonContent = file_get_contents($this->path);
            $this->logger->error($jsonContent);
/*            $person = $serializer->deserialize($data, Person::class, 'xml');*/
        } catch (\Exception $exception){
            $this->logger->error($exception);
            return false;
        }
        return true;

    }
}
