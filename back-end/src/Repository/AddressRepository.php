<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Address>
 *
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    /**
     * @return Address[] Returns an array of Address objects
     */
    public function findByExisting($country, $region, $city, $postal_code, $street): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.country = :country')
            ->andWhere('a.region = :region')
            ->andWhere('a.city = :city')
            ->andWhere('a.postal_code = :postal_code')
            ->andWhere('a.street = :street')
            ->setParameter('country', $country)
            ->setParameter('region', $region)
            ->setParameter('city', $city)
            ->setParameter('postal_code', $postal_code)
            ->setParameter('street', $street)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Address
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
