<?php

namespace App\Repository;

use App\Entity\ProductRecette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductRecette|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductRecette|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductRecette[]    findAll()
 * @method ProductRecette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRecetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductRecette::class);
    }

    // /**
    //  * @return ProductRecette[] Returns an array of ProductRecette objects
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
    public function findOneBySomeField($value): ?ProductRecette
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
