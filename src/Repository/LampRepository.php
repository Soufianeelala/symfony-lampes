<?php

namespace App\Repository;

use App\Entity\Lamp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lamp>
 */
class LampRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lamp::class);
    }

    //    /**
    //     * @return Lamp[] Returns an array of Lamp objects
    //     */
    public function findLastCubeId(int $value = 4): array
    {
        return $this->createQueryBuilder('l')
         //    ->andWhere('c.exampleField = :val')
         //    ->setParameter('val', $value)
            ->orderBy('l.id', 'DESC')
            ->setMaxResults($value)
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Lamp
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
