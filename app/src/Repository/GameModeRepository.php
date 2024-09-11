<?php

namespace App\Repository;

use App\Entity\GameMode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameMode>
 *
 * @method GameMode|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameMode|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameMode[]    findAll()
 * @method GameMode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameModeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameMode::class);
    }

    public function findBySlug(string|array $slug): array
    {
        $builder = $this->createQueryBuilder('gm');
        if (is_string($slug)) $builder->andWhere('gm.slug = :val');
        else $builder->where('gm.slug IN (:val)');

        return $builder->setParameter('val', $slug)
            ->getQuery()
            ->execute();
    }
}
