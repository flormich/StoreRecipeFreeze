<?php

namespace App\Repository;

use App\Entity\CommandeStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommandeStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeStock[]    findAll()
 * @method CommandeStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeStockRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommandeStock::class);
    }

    // /**
    //  * @return CommandeStock[] Returns an array of CommandeStock objects
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
    public function findOneBySomeField($value): ?CommandeStock
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
