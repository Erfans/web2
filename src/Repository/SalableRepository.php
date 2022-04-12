<?php

namespace App\Repository;

use App\Entity\Salable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Salable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salable[]    findAll()
 * @method Salable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salable::class);
    }

    // /**
    //  * @return Salable[] Returns an array of Salable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Salable
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
