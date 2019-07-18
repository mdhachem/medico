<?php

namespace App\Repository;

use App\Entity\Governorate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Governorate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Governorate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Governorate[]    findAll()
 * @method Governorate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GovernorateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Governorate::class);
    }

    // /**
    //  * @return Governorate[] Returns an array of Governorate objects
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
    public function findOneBySomeField($value): ?Governorate
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
