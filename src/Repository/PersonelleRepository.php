<?php

namespace App\Repository;

use App\Entity\Personelle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Personelle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personelle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personelle[]    findAll()
 * @method Personelle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonelleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personelle::class);
    }

    // /**
    //  * @return Personelle[] Returns an array of Personelle objects
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
    public function findOneBySomeField($value): ?Personelle
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
