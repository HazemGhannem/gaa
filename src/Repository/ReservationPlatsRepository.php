<?php

namespace App\Repository;

use App\Entity\ReservationPlats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReservationPlats|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationPlats|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationPlats[]    findAll()
 * @method ReservationPlats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationPlatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationPlats::class);
    }
    public function getNB()
    {

        $qb = $this->createQueryBuilder('r')
            ->select('COUNT(r.id_resPlat) AS res, (r.platId) AS plat')
            ->groupBy('plat');


        return $qb->getQuery()
            ->getResult();
    }
    public function trierdate()
    {
        $qb = $this->createQueryBuilder('r')
            ->orderBy('r.dateReservation', 'DESC');

        return $qb->getQuery()->getResult();
    }
    // /**
    //  * @return ReservationPlats[] Returns an array of ReservationPlats objects
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
    public function findOneBySomeField($value): ?ReservationPlats
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
