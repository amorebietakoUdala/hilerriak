<?php

namespace App\Repository;

use App\Entity\Movement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movement>
 *
 * @method Movement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movement[]    findAll()
 * @method Movement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movement::class);
    }

    public function add(Movement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Movement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
        * @return Movement[] Returns an array of Movement objects
        */
    public function findByCriteria($criteria, $orderBy = null, $limit = null, $offset = null): array
    {
        $criteriaLikeKeys = [
            'defunctName' => null,
            'defunctSurname1' => null,
            'defunctSurname2' => null,
        ];
        $criteriaLike = $criteriaAnd = null;
        if ( $criteria !== null ) {
            $criteriaLike = array_intersect_key($criteria,$criteriaLikeKeys);
            $criteriaAnd = array_diff_key($criteria,$criteriaLikeKeys);
        }
        $from = isset($criteriaAnd['deceaseDateFrom']) ? $criteriaAnd['deceaseDateFrom'] : null;
        unset($criteriaAnd['deceaseDateFrom']);
        $to = isset($criteriaAnd['deceaseDateTo']) ? $criteriaAnd['deceaseDateTo'] : null;
        unset($criteriaAnd['deceaseDateTo']);
        $qb = $this->createQueryBuilder('m');

        if ( $criteriaAnd ) {
            foreach ( $criteriaAnd as $field => $filter ) {
                $qb->andWhere('m.'.$field.' = :'.$field)
                    ->setParameter($field, $filter);
            }
        }
        if ( $criteriaLike ) {
            foreach ( $criteriaLike as $field => $filtroa ) {
                $qb->andWhere('m.'.$field.' LIKE :'.$field)
                    ->setParameter($field, '%'.$filtroa.'%');
            }
        }
        if ($from) {
            $qb->andWhere('m.deceaseDate >= :deceaseDateFrom')
            ->setParameter('deceaseDateFrom', $from);
        }
        if ($to) {
            $qb->andWhere('m.deceaseDate <= :deceaseDateTo')
            ->setParameter('deceaseDateTo', $to);
        }
        $qb->orderBy('m.id', 'DESC');
        $qb->setMaxResults($limit);
        return $qb->getQuery()->getResult();
    }

//    public function findOneBySomeField($value): ?Movement
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

