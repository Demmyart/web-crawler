<?php

namespace App\Repository;

use App\Entity\GrabResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GrabResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method GrabResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method GrabResult[]    findAll()
 * @method GrabResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrabResultRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GrabResult::class);
    }

    // /**
    //  * @return GrabResult[] Returns an array of GrabResult objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GrabResult
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
