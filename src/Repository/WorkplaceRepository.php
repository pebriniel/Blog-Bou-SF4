<?php

namespace App\Repository;

use App\Entity\Workplace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Workplace|null find($id, $lockMode = null, $lockVersion = null)
 * @method Workplace|null findOneBy(array $criteria, array $orderBy = null)
 * @method Workplace[]    findAll()
 * @method Workplace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkplaceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Workplace::class);
    }

//    /**
//     * @return Workplace[] Returns an array of Workplace objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Workplace
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
