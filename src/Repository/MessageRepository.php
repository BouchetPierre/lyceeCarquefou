<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }


    /**
     * Les messages envoyés en fonction du user
     *
     * @return Message[] Returns an array of Reservation objects
     */

    public function findByUser($user)
    {
        return $this->createQueryBuilder('m')
            ->select()
            ->where('m.author = :val')
            ->setParameter('val', $user)
            ->innerJoin('m.author', 'am', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.author = am.id' )
            ->innerJoin('m.destinataire', 'dm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.destinataire = dm.id' )
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Les messages reçus en fonction du user
     *
     * @return Message[] Returns an array of Reservation objects
     */

    public function findByDest($user)
    {
        return $this->createQueryBuilder('m')
            ->select()
            ->where('dm.author = :val')
            ->setParameter('val', $user)
            ->innerJoin('m.author', 'am', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.author = am.id' )
            ->innerJoin('m.destinataire', 'dm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.destinataire = dm.id' )
            ->getQuery()
            ->getResult()
            ;
    }


    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
