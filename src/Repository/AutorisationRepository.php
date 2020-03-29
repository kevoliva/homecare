<?php

namespace App\Repository;

use App\Entity\Autorisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Autorisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Autorisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Autorisation[]    findAll()
 * @method Autorisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutorisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Autorisation::class);
    }

    // /**
    //  * @return Autorisation[] Returns an array of Autorisation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Autorisation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByIdBien($idBien)
  {
      return $this->createQueryBuilder('a')
          ->join('a.bien', 'b')
          ->andWhere('b.id = :idBien')
          ->setParameter('idBien', $idBien)
          ->join('a.professionnel', 'p')
          ->orderBy('p.nomEntrep', 'ASC')
          ->getQuery()
          ->getResult()
      ;
  }

  public function findByIdBienOrdreDesalphabetique($idBien)
{
    return $this->createQueryBuilder('a')
        ->join('a.bien', 'b')
        ->andWhere('b.id = :idBien')
        ->setParameter('idBien', $idBien)
        ->join('a.professionnel', 'p')
        ->orderBy('p.nomEntrep', 'DESC')
        ->getQuery()
        ->getResult()
    ;
}

  public function findByAutorisation($proConnecte, $bien)
{
    return $this->createQueryBuilder('a')
        ->join('a.bien', 'b')
        ->join('a.professionnel', 'p')
        ->andWhere('a.professionnel = :proConnecte')
        ->andWhere('a.bien = :bien')
        ->setParameter('proConnecte', $proConnecte)
        ->setParameter('bien', $bien)
        ->getQuery()
        ->getResult()
    ;
}
}
