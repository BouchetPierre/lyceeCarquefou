<?php

namespace App\Repository;

use App\Entity\AdminPublication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AdminPublication|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminPublication|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminPublication[]    findAll()
 * @method AdminPublication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminPublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminPublication::class);
    }

     /**
      * @return AdminPublication[] Returns an array of AdminPublication objects
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
     * @return AdminPublication[] Returns an array of AdminPublication objects
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
    public function findOneBySomeField($value): ?AdminPublication
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
