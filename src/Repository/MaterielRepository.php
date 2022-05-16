<?php

namespace App\Repository;

use App\Entity\Search;
use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Materiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Materiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Materiel[]    findAll()
 * @method Materiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Materiel::class);
    }
    /**
     * @param Search $search
     * @return Materiel[]
     */
    public function findWithSearch(Search $search)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p');



        if(!empty($search->string)) {

            $query = $query
                ->andWhere('p.nom_materiel LIKE :string')
                ->setParameter('string',"%{$search->string}%");
        }
        return $query->getQuery()->getResult();
    }
    public function trierdate()
    {
        $qb = $this->createQueryBuilder('r')
            ->orderBy('r.nom_materiel', 'ASC');

        return $qb->getQuery()->getResult();
    }


    // /**
    //  * @return Materiel[] Returns an array of Materiel objects
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
    public function findOneBySomeField($value): ?Materiel
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
