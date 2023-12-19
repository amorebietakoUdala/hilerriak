<?php

namespace App\Repository;

use App\Entity\GraveType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GraveType>
 *
 * @method GraveType|null find($id, $lockMode = null, $lockVersion = null)
 * @method GraveType|null findOneBy(array $criteria, array $orderBy = null)
 * @method GraveType[]    findAll()
 * @method GraveType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GraveTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GraveType::class);
    }

    public function add(GraveType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GraveType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
