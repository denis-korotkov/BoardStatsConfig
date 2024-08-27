<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findOneByName(string $name): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.Name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findBySlug(string|array $slug): array
    {
        $builder = $this->createQueryBuilder('g');
        if (is_string($slug)) $builder->andWhere('g.slug = :val');
        else $builder->where('g.slug IN (:val)');

        return $builder->setParameter('val', $slug)
            ->getQuery()
            ->execute();
    }
}
