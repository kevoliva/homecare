<?php

namespace App\Repository;

use App\Entity\Bien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
* @method Bien|null find($id, $lockMode = null, $lockVersion = null)
* @method Bien|null findOneBy(array $criteria, array $orderBy = null)
* @method Bien[]    findAll()
* @method Bien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
*/
class BienRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Bien::class);
  }

  // /**
  //  * @return Bien[] Returns an array of Bien objects
  //  */
  /*
  public function findByExampleField($value)
  {
  return $this->createQueryBuilder('b')
  ->andWhere('b.exampleField = :val')
  ->setParameter('val', $value)
  ->orderBy('b.id', 'ASC')
  ->setMaxResults(10)
  ->getQuery()
  ->getResult()
  ;
}
*/

/*
public function findOneBySomeField($value): ?Bien
{
return $this->createQueryBuilder('b')
->andWhere('b.exampleField = :val')
->setParameter('val', $value)
->getQuery()
->getOneOrNullResult()
;
}
*/


public function getBiensClients($proConnecte)
{

  return $this->createQueryBuilder('b')
  ->join('b.autorisations', 'a')
  ->join('a.professionnel', 'p')
  ->andWhere('a.professionnel = :proConnecte')
  ->setParameter('proConnecte', $proConnecte)
  ->join('b.proprietaire', 'proprietaire')
  ->orderBy('proprietaire.nom', 'ASC')
  ->getQuery()
  ->getResult();
}

public function getBiensProprietaire($proprietaireConnecte)
{
  return $this->createQueryBuilder('b')
  ->join('b.proprietaire', 'p')
  ->andWhere('b.proprietaire = :proprietaireConnecte')
  ->setParameter('proprietaireConnecte', $proprietaireConnecte)
  ->getQuery()
  ->getResult();
}
}
