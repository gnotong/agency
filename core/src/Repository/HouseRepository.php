<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\House;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    public function findAllNotSold(): array
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
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

    // /**
    //  * @return House[] Returns an array of House objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?House
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
