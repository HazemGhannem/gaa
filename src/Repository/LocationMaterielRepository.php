<?php

namespace App\Repository;

use App\Entity\LocationMateriel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LocationMateriel|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocationMateriel|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocationMateriel[]    findAll()
 * @method LocationMateriel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationMaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocationMateriel::class);
    }

    // /**
    //  * @return LocationMateriel[] Returns an array of LocationMateriel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LocationMateriel
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
