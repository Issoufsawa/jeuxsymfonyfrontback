<?php

namespace App\Repository;

use App\Entity\Actualitevideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Actualitevideo>
 *
 * @method Actualitevideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actualitevideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actualitevideo[]    findAll()
 * @method Actualitevideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualitevideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actualitevideo::class);
    }

//    /**
//     * @return Actualitevideo[] Returns an array of Actualitevideo objects
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

//    public function findOneBySomeField($value): ?Actualitevideo
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
