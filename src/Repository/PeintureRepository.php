<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\Peinture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Peinture>
 *
 * @method Peinture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Peinture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Peinture[]    findAll()
 * @method Peinture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeintureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Peinture::class);
    }
      /**
       * @return Peinture[] retrun array of Peinture objects
       */
    public function Lastree()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

   /**
    * @return Peinture[] Returns an array of Peinture objects
    */
   public function findAllPortfolio(Categorie $categorie): array
   {
       return $this->createQueryBuilder('p')
           ->Where(':categorie MEMBER OF p.categorie')
           ->andWhere('p.portfolio = TRUE')
           ->setParameter('categorie', $categorie)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Peinture
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
