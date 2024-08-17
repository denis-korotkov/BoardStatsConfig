<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Result;
use App\Service\FieldValidatorService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Result>
 *
 * @method Result|null find($id, $lockMode = null, $lockVersion = null)
 * @method Result|null findOneBy(array $criteria, array $orderBy = null)
 * @method Result[]    findAll()
 * @method Result[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Result::class);
    }

    /**
     * @return Result[]
     */
    public function findByGame(int $gameId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.game_id = :val')
            ->setParameter('val', $gameId)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function create(Game $game, EntityManagerInterface $entityManager, FieldValidatorService $fieldValidatorService, array $payload){
        $result = new Result();
        $result->setGame($game);

        $value = $fieldValidatorService->validate($payload, $game);
        $result->setValue($value);

        $entityManager->persist($result);
        $entityManager->flush();
    }
}
