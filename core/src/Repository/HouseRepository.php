<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\House;
use App\Entity\HouseSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method House|null find($id, $lockMode = null, $lockVersion = null)
 * @method House|null findOneBy(array $criteria, array $orderBy = null)
 * @method House[]    findAll()
 * @method House[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
    public function findAllForSale(): array
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
    }

    public function findByHouseSearch(HouseSearch $houseSearch): Query
    {
        $qb = $this->findVisibleQuery();

        if (!empty($houseSearch->getPrice())) {
            $qb = $qb->andWhere('h.price >= :price')
                ->setParameter('price', $houseSearch->getPrice());
        }

        if (!empty($houseSearch->getMinSurface())) {
            $qb = $qb->andWhere('h.surface >= :minSurface')
                ->setParameter('minSurface', $houseSearch->getMinSurface());
        }

        if ($houseSearch->getOptions()->count() > 0) {
            $k = 0;
            foreach ($houseSearch->getOptions() as $option) {
                $k++;
                $qb = $qb->andWhere(":option$k MEMBER OF h.options")->setParameter("option$k", $option->getId());
            }
        }

        return $qb->getQuery();
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
