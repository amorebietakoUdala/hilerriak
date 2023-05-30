<?php

namespace App\Repository;

use App\Entity\HistoryMovements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryMovements>
 *
 * @method HistoryMovements|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryMovements|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryMovements[]    findAll()
 * @method HistoryMovements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryMovementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryMovements::class);
    }

    public function add(HistoryMovements $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoryMovements $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
        * @return HistoryMovements[] Returns an array of Movement objects
        */
        public function findByCriteria($criteria, $orderBy = null, $limit = null, $offset = null): array
        {
            $criteriaLikeKeys = [
                'difunto' => null,
                'tipoAccion' => null,
            ];
            $criteriaLike = $criteriaAnd = null;
            if ( $criteria !== null ) {
                $criteriaLike = array_intersect_key($criteria,$criteriaLikeKeys);
                $criteriaAnd = array_diff_key($criteria,$criteriaLikeKeys);
            }
            $from = isset($criteriaAnd['fechaRegistroFrom']) ? $criteriaAnd['fechaRegistroFrom'] : null;
            unset($criteriaAnd['fechaRegistroFrom']);
            $to = isset($criteriaAnd['fechaRegistroTo']) ? $criteriaAnd['fechaRegistroTo'] : null;
            unset($criteriaAnd['fechaRegistroTo']);
            $qb = $this->createQueryBuilder('hm');
    
            if ( $criteriaAnd ) {
                foreach ( $criteriaAnd as $field => $filter ) {
                    $qb->andWhere('hm.'.$field.' = :'.$field)
                        ->setParameter($field, $filter);
                }
            }
            if ( $criteriaLike ) {
                foreach ( $criteriaLike as $field => $filtroa ) {
                    $qb->andWhere('hm.'.$field.' LIKE :'.$field)
                        ->setParameter($field, '%'.$filtroa.'%');
                }
            }
            if ($from) {
                $qb->andWhere('hm.fechaRegistro >= :fechaRegistroFrom')
                ->setParameter('fechaRegistroFrom', $from);
            }
            if ($to) {
                $qb->andWhere('hm.fechaRegistro <= :fechaRegistroTo')
                ->setParameter('fechaRegistroTo', $to);
            }
            $qb->orderBy('hm.id', 'DESC');
            $qb->setMaxResults($limit);
            return $qb->getQuery()->getResult();
        }
    

//    /**
//     * @return historyMovements[] Returns an array of historyMovements objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?historyMovements
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
