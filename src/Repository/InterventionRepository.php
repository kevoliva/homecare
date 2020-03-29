<?php

namespace App\Repository;

use App\Entity\Intervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Intervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervention[]    findAll()
 * @method Intervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intervention::class);
    }

    // /**
    //  * @return Intervention[] Returns an array of Intervention objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Intervention
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByIdBien($idBien)
   {
       return $this->createQueryBuilder('i')
           ->join('i.bien', 'b')
           ->andWhere('b.id = :idBien')
           ->setParameter('idBien', $idBien)
           ->orderBy('i.libelle', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

   public function findByIdBienOrdreDesalphabetique($idBien)
  {
      return $this->createQueryBuilder('i')
          ->join('i.bien', 'b')
          ->andWhere('b.id = :idBien')
          ->setParameter('idBien', $idBien)
          ->orderBy('i.libelle', 'DESC')
          ->getQuery()
          ->getResult()
      ;
  }

  public function findByIdBienRecent($idBien)
 {
     return $this->createQueryBuilder('i')
         ->join('i.bien', 'b')
         ->andWhere('b.id = :idBien')
         ->setParameter('idBien', $idBien)
         ->orderBy('i.laDate', 'DESC')
         ->getQuery()
         ->getResult()
     ;
 }

 public function findByIdBienAncien($idBien)
{
    return $this->createQueryBuilder('i')
        ->join('i.bien', 'b')
        ->andWhere('b.id = :idBien')
        ->setParameter('idBien', $idBien)
        ->orderBy('i.laDate', 'ASC')
        ->getQuery()
        ->getResult()
    ;
}
}
