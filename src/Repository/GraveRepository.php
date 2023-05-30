<?php

namespace App\Repository;

use App\Entity\Cemetery;
use App\Entity\Grave;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Grave>
 *
 * @method Grave|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grave|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grave[]    findAll()
 * @method Grave[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GraveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grave::class);
    }

    public function add(Grave $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Grave $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Grave[] Returns an array of Grave objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

   public function findByCemeteryAndSide(Cemetery $cemetery, $side): ?array
   {
       return $this->createQueryBuilder('g')
           ->andWhere('g.cemetery = :cemetery')
           ->andWhere('g.side = :side')
           ->setParameter('cemetery', $cemetery)
           ->setParameter('side', $side)
           ->setMaxResults(1)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findByCemeteryNumberAndLetter(Cemetery $cemetery, $zone, $letter): ?array
   {
       return $this->createQueryBuilder('g')
           ->andWhere('g.cemetery = :cemetery')
           ->andWhere('g.side = :side')
           ->andWhere('g.zoneOrRow = :zone')
           ->setParameter('cemetery', $cemetery)
           ->setParameter('side', $letter)
           ->setParameter('zone', $zone)
           ->setMaxResults(1)
           ->getQuery()
           ->getResult()
       ;
   }

}
