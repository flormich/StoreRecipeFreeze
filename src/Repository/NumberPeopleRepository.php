<?php

namespace App\Repository;

use App\Entity\NumberPeople;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NumberPeople|null find($id, $lockMode = null, $lockVersion = null)
 * @method NumberPeople|null findOneBy(array $criteria, array $orderBy = null)
 * @method NumberPeople[]    findAll()
 * @method NumberPeople[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumberPeopleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NumberPeople::class);
    }

    // /**
    //  * @return NumberPeople[] Returns an array of NumberPeople objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NumberPeople
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
