<?php

namespace App\Repository;

use App\Entity\PhotoEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoEvent[]    findAll()
 * @method PhotoEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoEvent::class);
    }

    // /**
    //  * @return PhotoEvent[] Returns an array of PhotoEvent objects
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
    public function findOneBySomeField($value): ?PhotoEvent
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
