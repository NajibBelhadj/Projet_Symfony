<?php

namespace App\Repository;

use App\Entity\CenterInreret;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CenterInreret|null find($id, $lockMode = null, $lockVersion = null)
 * @method CenterInreret|null findOneBy(array $criteria, array $orderBy = null)
 * @method CenterInreret[]    findAll()
 * @method CenterInreret[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CenterInreretRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CenterInreret::class);
    }

    // /**
    //  * @return CenterInreret[] Returns an array of CenterInreret objects
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
    public function findOneBySomeField($value): ?CenterInreret
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
