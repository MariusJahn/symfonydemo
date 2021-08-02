<?php

namespace App\Repository;

use App\Entity\Betriebsmittel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Betriebsmittel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Betriebsmittel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Betriebsmittel[]    findAll()
 * @method Betriebsmittel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BetriebsmittelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Betriebsmittel::class);
    }

    // /**
    //  * @return Betriebsmittel[] Returns an array of Betriebsmittel objects
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
    public function findOneBySomeField($value): ?Betriebsmittel
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
