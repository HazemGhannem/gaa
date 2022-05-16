<?php

namespace App\Repository;

use App\Entity\ReservationCompetition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReservationCompetition|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationCompetition|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationCompetition[]    findAll()
 * @method ReservationCompetition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationCompetitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationCompetition::class);
    }

    // /**
    //  * @return ReservationCompetition[] Returns an array of ReservationCompetition objects
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
    public function findOneBySomeField($value): ?ReservationCompetition
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
