<?php

namespace App\Repository;

use App\Entity\Professionnel;
use App\Entity\Bien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
* @method Professionnel|null find($id, $lockMode = null, $lockVersion = null)
* @method Professionnel|null findOneBy(array $criteria, array $orderBy = null)
* @method Professionnel[]    findAll()
* @method Professionnel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
*/
class ProfessionnelRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Professionnel::class);
  }

  // /**
  //  * @return Professionnel[] Returns an array of Professionnel objects
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
public function findOneBySomeField($value): ?Professionnel
{
return $this->createQueryBuilder('p')
->andWhere('p.exampleField = :val')
->setParameter('val', $value)
->getQuery()
->getOneOrNullResult()
;
}
*/

public function entreprisesOrdreAlpha($id){
  $resultats = $this -> createQueryBuilder ('p')
  -> leftJoin ('p.autorisations', 'a')
  // -> leftJoin ('a.bien', 'b')
  -> andWhere ('a.bien != :bien')
  -> orWhere('a.bien is NULL')
  -> setParameter ('bien', $id)
  -> orderBy ('p.nomEntrep', 'ASC');
  dump($resultats);
  return $resultats;
}

public function getUsernameProprietaireIfAuthorization($bien){
  return $this->createQueryBuilder('proprietaire')
  ->join('bien.autorisations', 'a')
  ->join('a.professionnel', 'professionnel')
  ->setParameter('bien', $bien)
  ->getQuery()
  ->getResult();
}

}
