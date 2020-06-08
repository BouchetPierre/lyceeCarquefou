<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method findOneById($id)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    /**
     * @return Annonce[] Returns an array of Annonce objects
    */

    public function findByType($type)
    {
        return $this->createQueryBuilder('a')
            ->where('a.type = :val')
            ->setParameter('val', $type)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllForForm($form)
    {
        return $this->createQueryBuilder('a')
            ->select()
            ->where('(a.typeScoolOne = :val) or (a.typeScoolTwo = :val) or (a.typeScoolThree = :val)')
            ->setParameter('val', $form)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Annonce
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
