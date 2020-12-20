<?php

namespace App\Repository;

use App\Entity\Biens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Biens|null find($id, $lockMode = null, $lockVersion = null)
 * @method Biens|null findOneBy(array $criteria, array $orderBy = null)
 * @method Biens[]    findAll()
 * @method Biens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BiensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Biens::class);
    }



    public function findAllVisible() {

        return $this->createQueryBuilder('b')
            ->where('b.sold = false')
            ->getQuery()
            ->getResult();


    }

 
    /**
    * @return 
    */
    public function findLatest(): array
    {
/*       return $this->createQueryBuilder('p')
        ->where('p.sold = false') */
        return $this->findVisibleQuery()
                    ->setMaxResults(4)
                    ->getQuery()
                    ->getResult();
        
    }
 
 
    private function findVisibleQuery() {
        return $this->createQueryBuilder('p')
                    ->where('p.sold = false');


    }    
    

    // /**
    //  * @return Biens[] Returns an array of Biens objects
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
    public function findOneBySomeField($value): ?Biens
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
