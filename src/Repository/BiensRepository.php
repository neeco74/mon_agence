<?php

namespace App\Repository;

use App\Entity\Biens;
use App\Entity\BiensSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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



     /**
    * @return Query 
    */
    public function findAllVisibleQuery(BiensSearch $search)
    {
        $query = $this->findVisibleQuery();

            if ($search->getMaxPrice()) {
                $query = $query->andWhere('p.price <= :maxprice');
                $query = $query->setParameter('maxprice', $search->getMaxPrice());

            }

            if ($search->getMinSurface()) {
                $query = $query->andWhere('p.surface >= :minsurface');
                $query = $query->setParameter('minsurface', $search->getMinSurface());

            }

    
            if($search->getOptions()->count() > 0) {
                $k = 0;
                foreach($search->getOptions() as $k => $option) {
                    $k++;
                    $query = $query
                        ->andWhere(":option$k MEMBER OF p.options")
                        ->setParameter("option$k", $option);
                }
            }
            

            return $query->getQuery();
   
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
