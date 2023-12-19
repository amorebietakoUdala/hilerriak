<?php

namespace App\Repository;

use App\Entity\Adjudication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adjudication>
 *
 * @method Adjudication|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adjudication|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adjudication[]    findAll()
 * @method Adjudication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdjudicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adjudication::class);
    }

    public function add(Adjudication $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Adjudication $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

        /**
            * @return Adjudication[] Returns an array of Adjudication objects
            */
        public function findByCriteria($criteria, $orderBy = null, $limit = null, $offset = null): array
        {
            $qb = $this->createQueryBuilder('a')
                ->join('a.grave', 'g');
            if (isset($criteria["cemetery"])) {
                $qb->andWhere('g.cemetery = :cemetery')
                    ->setParameter('cemetery', $criteria["cemetery"]);
            }
            if (isset($criteria["grave"])) {
                $qb->andWhere('a.grave = :grave')
                    ->setParameter('grave', $criteria["grave"]);
            }
            if (isset($criteria["owner"])) {
            $qb->andWhere('a.owner = :owner')
                ->setParameter('owner', $criteria['owner']);
            }
            if (isset($criteria["expired"])) {
                $qb->andWhere('a.expiryYear < :year')
                    ->setParameter('year', (new \DateTime())->format('Y'));
            }
                //dd($qb->orderBy('a.id', 'ASC')->getQuery()->getResult());
            if ($orderBy) {
                $qb->orderBy('a.'.array_keys($orderBy)[0], $orderBy[array_keys($orderBy)[0]]);
            }
            return $qb
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult()
            ;
        }


    /**
    * @return Owner[] Returns an array of Owner objects
    */
    public function findByCemetery($value): array
    {   
        return $this->createQueryBuilder('a')
            ->select('o.id,o.fullname')
            ->distinct()
            ->join('a.grave', 'g')
            ->join('a.owner', 'o')
            ->andWhere("g.cemetery = :cemetery")
            ->setParameter('cemetery', "$value")
            ->orderBy('o.fullname', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
