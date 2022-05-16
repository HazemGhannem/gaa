<?php

namespace App\Repository;

use App\Entity\ParticipationEve;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParticipationEve|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParticipationEve|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParticipationEve[]    findAll()
 * @method ParticipationEve[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipationEveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParticipationEve::class);
    }

    // /**
    //  * @return ParticipationEve[] Returns an array of ParticipationEve objects
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
    public function findOneBySomeField($value): ?ParticipationEve
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
