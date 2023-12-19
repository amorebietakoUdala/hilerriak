<?php

namespace App\Repository;

use App\Entity\MovementType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MovementType>
 *
 * @method MovementType|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovementType|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovementType[]    findAll()
 * @method MovementType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovementTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovementType::class);
    }

    public function add(MovementType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MovementType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
