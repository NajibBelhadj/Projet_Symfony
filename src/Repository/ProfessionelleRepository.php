<?php

namespace App\Repository;

use App\Entity\Professionelle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Professionelle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Professionelle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Professionelle[]    findAll()
 * @method Professionelle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfessionelleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Professionelle::class);
    }

    // /**
    //  * @return Professionelle[] Returns an array of Professionelle objects
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
    public function findOneBySomeField($value): ?Professionelle
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
