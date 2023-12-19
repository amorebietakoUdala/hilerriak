<?php

namespace App\Repository;

use App\Entity\Owner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Owner>
 *
 * @method Owner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Owner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Owner[]    findAll()
 * @method Owner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Owner::class);
    }

    public function add(Owner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Owner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Owner[] Returns an array of Owner objects
    */
    public function findByDni($value): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere("o.dni like :dni")
            ->setParameter('dni', "$value%")
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Owner[] Returns an array of Owner objects
    */
    public function findByCriteria(array $criteria): array
    {
        if ( isset($criteria['id']) ) {
            $result = $this->find($criteria['id']);
            return [$result];
        }

        $qb = $this->createQueryBuilder('o');
        if ( isset($criteria['dni']) ) {
            $dni = $criteria['dni'];
            $qb->andWhere("o.dni like :dni")
            ->setParameter('dni', "%$dni%");
        }
        if ( isset($criteria['fullname']) ) {
            $fullname = $criteria['fullname'];
            $qb->andWhere("o.fullname like :fullname")
            ->setParameter('fullname', "%$fullname%");
        }
        return $qb->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

    }
}
