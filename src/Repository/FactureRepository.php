<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    // /**
    //  * @return Facture[] Returns an array of Facture objects
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
    public function findOneBySomeField($value): ?Facture
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
      * @return Stage[] Returns an array of Stage objects
      */

    public function findByIdBien($idBien)
    {
        return $this->createQueryBuilder('f')
            ->join('f.bien', 'b')
            ->andWhere('b.id = :idBien')
            ->setParameter('idBien', $idBien)
            ->orderBy('f.libelle', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByIdBienOrdreDesalphabetique($idBien)
    {
        return $this->createQueryBuilder('f')
            ->join('f.bien', 'b')
            ->andWhere('b.id = :idBien')
            ->setParameter('idBien', $idBien)
            ->orderBy('f.libelle', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByIdBienRecent($idBien)
    {
        return $this->createQueryBuilder('f')
            ->join('f.bien', 'b')
            ->andWhere('b.id = :idBien')
            ->setParameter('idBien', $idBien)
            ->orderBy('f.laDate', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByIdBienAncien($idBien)
    {
        return $this->createQueryBuilder('f')
            ->join('f.bien', 'b')
            ->andWhere('b.id = :idBien')
            ->setParameter('idBien', $idBien)
            ->orderBy('f.laDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
