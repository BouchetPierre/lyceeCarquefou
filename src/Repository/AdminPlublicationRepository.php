<?php

namespace App\Repository;

use App\Entity\AdminPlublication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AdminPlublication|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminPlublication|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminPlublication[]    findAll()
 * @method AdminPlublication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminPlublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminPlublication::class);
    }

     /**
      * @return AdminPlublication[] Returns an array of AdminPlublication objects
      */

    public function findLast()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return AdminPlublication[] Returns an array of AdminPlublication objects
     */

    public function findAll2()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?AdminPlublication
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
