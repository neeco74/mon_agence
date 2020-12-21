<?php

namespace App\Repository;

use App\Entity\BiensSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BiensSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method BiensSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method BiensSearch[]    findAll()
 * @method BiensSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BiensSearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BiensSearch::class);
    }

    // /**
    //  * @return BiensSearch[] Returns an array of BiensSearch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BiensSearch
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
