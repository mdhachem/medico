<?php

namespace App\Repository;

use App\Entity\RawMaterial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RawMaterial|null find($id, $lockMode = null, $lockVersion = null)
 * @method RawMaterial|null findOneBy(array $criteria, array $orderBy = null)
 * @method RawMaterial[]    findAll()
 * @method RawMaterial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RawMaterialRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RawMaterial::class);
    }

    // /**
    //  * @return RawMaterial[] Returns an array of RawMaterial objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RawMaterial
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
