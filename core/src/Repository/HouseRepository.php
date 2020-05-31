<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\House;
use App\Entity\HouseSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method House|null find($id, $lockMode = null, $lockVersion = null)
 * @method House|null findOneBy(array $criteria, array $orderBy = null)
 * @method House[]    findAll()
// * @method House[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HouseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, House::class);
    }

    /**
     * @return array|House[]
     */
    public function findAllNotSold(): array
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
    }

    public function findByCriteria(HouseSearch $houseSearch): QueryBuilder
    {
        $qb = $this->findVisibleQuery();

        if (!empty($houseSearch->getPrice())) {
            $qb->andWhere('h.price >= :price')
                ->setParameter('price', $houseSearch->getPrice());
        }

        if (!empty($houseSearch->getMinSurface())) {
            $qb->andWhere('h.surface >= :minSurface')
                ->setParameter('minSurface', $houseSearch->getMinSurface());
        }

        return $qb;
    }

    /**
     * @return House[]
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->orderBy('h.createdAt', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('h')
            ->where('h.sold = false');
    }
}
