<?php

namespace App\Repository;

use App\Entity\Petitioner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Petitioner>
 *
 * @method Petitioner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Petitioner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Petitioner[]    findAll()
 * @method Petitioner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetitionerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Petitioner::class);
    }

    public function add(Petitioner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Petitioner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Petitioner[] Returns an array of Petitioner objects
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
    * @return Petitioner[] Returns an array of Petitioner objects
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
