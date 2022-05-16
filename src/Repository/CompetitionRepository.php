<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Competition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Competition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competition[]    findAll()
 * @method Competition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competition::class);
    }
    /**
     * @param Search $search
     * @return Competition[]
     */
    public function findWithSearch(Search $search)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p');



        if(!empty($search->string)) {

            $query = $query
                ->andWhere('p.Nom LIKE :string')
                ->setParameter('string',"%{$search->string}%");
        }
        return $query->getQuery()->getResult();
    }
    public function trierdate()
    {
        $qb = $this->createQueryBuilder('r')
            ->orderBy('r.date', 'ASC');

        return $qb->getQuery()->getResult();
    }
    // /**
    //  * @return Competition[] Returns an array of Competition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Competition
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
