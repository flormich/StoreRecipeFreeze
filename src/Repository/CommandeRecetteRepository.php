<?php

namespace App\Repository;

use App\Entity\CommandeRecette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommandeRecette|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeRecette|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeRecette[]    findAll()
 * @method CommandeRecette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRecetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommandeRecette::class);
    }

    // /**
    //  * @return CommandeRecette[] Returns an array of CommandeRecette objects
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
    public function findOneBySomeField($value): ?CommandeRecette
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
