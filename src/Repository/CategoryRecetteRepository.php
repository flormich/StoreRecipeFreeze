<?php

namespace App\Repository;

use App\Entity\CategoryRecette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategoryRecette|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryRecette|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryRecette[]    findAll()
 * @method CategoryRecette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRecetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategoryRecette::class);
    }

    // /**
    //  * @return CategoryRecette[] Returns an array of CategoryRecette objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryRecette
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
