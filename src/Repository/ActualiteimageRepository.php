<?php

namespace App\Repository;

use App\Entity\Actualiteimage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Actualiteimage>
 *
 * @method Actualiteimage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actualiteimage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actualiteimage[]    findAll()
 * @method Actualiteimage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualiteimageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actualiteimage::class);
    }

//    /**
//     * @return Actualiteimage[] Returns an array of Actualiteimage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Actualiteimage
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findLastThree(): array
{
    return $this->createQueryBuilder('a')
        ->orderBy('a.id', 'DESC')
        ->setMaxResults(3)
        ->getQuery()
        ->getResult();
}
}
