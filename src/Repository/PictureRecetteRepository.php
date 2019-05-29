<?php

namespace App\Repository;

use App\Entity\PictureRecette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PictureRecette|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictureRecette|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictureRecette[]    findAll()
 * @method PictureRecette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRecetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PictureRecette::class);
    }

    // /**
    //  * @return PictureRecette[] Returns an array of PictureRecette objects
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
    public function findOneBySomeField($value): ?PictureRecette
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
