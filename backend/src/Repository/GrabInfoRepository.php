<?php

namespace App\Repository;

use App\Entity\GrabInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GrabInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method GrabInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method GrabInfo[]    findAll()
 * @method GrabInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrabInfoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GrabInfo::class);
    }

    // /**
    //  * @return GrabInfo[] Returns an array of GrabInfo objects
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
    public function findOneBySomeField($value): ?GrabInfo
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
