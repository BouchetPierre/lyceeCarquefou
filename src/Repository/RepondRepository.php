<?php

namespace App\Repository;


use App\Entity\Repond;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Repond|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repond|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repond[]    findAll()
 * @method Repond[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepondRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repond::class);
    }

    /**
     * Les réponses reçues en fonction du user
     *
     * @return Repond[] Returns an array of Reservation objects
     */

    public function findByUserRecu($user)
    {
        return $this->createQueryBuilder('m')
            ->select()
            ->where('m.destinataire = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Les réponses envoyées en fonction du user
     *
     * @return Repond[] Returns an array of Reservation objects
     */

    public function findByUserSend($user)
    {
        return $this->createQueryBuilder('m')
            ->select()
            ->where('m.author = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Repond[] Returns an array of Repond objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Repond
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
