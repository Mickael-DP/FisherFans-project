<?php

namespace App\Repository;

use App\Entity\FishingTrip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FishingTrip>
 *
 * @method FishingTrip|null find($id, $lockMode = null, $lockVersion = null)
 * @method FishingTrip|null findOneBy(array $criteria, array $orderBy = null)
 * @method FishingTrip[]    findAll()
 * @method FishingTrip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FishingTripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FishingTrip::class);
    }

//    /**
//     * @return FishingTrip[] Returns an array of FishingTrip objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FishingTrip
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
