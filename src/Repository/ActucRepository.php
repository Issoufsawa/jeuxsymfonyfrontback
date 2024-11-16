<?php

namespace App\Repository;

use App\Entity\Actuc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Actuc>
 *
 * @method Actuc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actuc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actuc[]    findAll()
 * @method Actuc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActucRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actuc::class);
    }

//    /**
//     * @return Actuc[] Returns an array of Actuc objects
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

//    public function findOneBySomeField($value): ?Actuc
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



public function findFirstthree()
{
    return $this->createQueryBuilder('a')
        ->setMaxResults(3)
        ->getQuery()
        ->getResult();
}

public function findLastFive(): array
{
    return $this->createQueryBuilder('a')
        ->orderBy('a.id', 'DESC')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();
}





}
