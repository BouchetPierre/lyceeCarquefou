<?php

namespace App\Repository;

use App\Entity\PictureUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PictureUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictureUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictureUser[]    findAll()
 * @method PictureUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PictureUser::class);
    }

    // /**
    //  * @return PictureUser[] Returns an array of PictureUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PictureUser
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
