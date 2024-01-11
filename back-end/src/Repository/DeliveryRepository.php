<?php

namespace App\Repository;

use App\Entity\Delivery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Delivery>
 *
 * @method Delivery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Delivery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Delivery[]    findAll()
 * @method Delivery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Delivery::class);
    }

    /**
     * @return Delivery[] Returns an array of Delivery objects
     */
    public function findBetweenDate($startDate, $endDate): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.start_date BETWEEN :startDate AND :endDate')
            ->orWhere('d.end_date BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();
    }

    public function findBetweenDateAndTruckType($startDate, $endDate, $truckType): array
    {
        return $this->createQueryBuilder('d')
            ->join('d.vehicle', 'v')
            ->join('v.vehicle_type', 'vt')
            ->where('d.start_date BETWEEN :startDate AND :endDate')
            ->orWhere('d.end_date BETWEEN :startDate AND :endDate')
            ->andWhere('vt.type = :vehicleType')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('vehicleType', $truckType)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Delivery
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
