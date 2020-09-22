<?php

namespace App\Repository;

use App\Entity\FichierTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FichierTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichierTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichierTheme[]    findAll()
 * @method FichierTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichierThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichierTheme::class);
    }

    // /**
    //  * @return FichierTheme[] Returns an array of FichierTheme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FichierTheme
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
