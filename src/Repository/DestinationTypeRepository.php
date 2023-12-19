<?php

namespace App\Repository;

use App\Entity\DestinationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DestinationType>
 *
 * @method DestinationType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DestinationType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DestinationType[]    findAll()
 * @method DestinationType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DestinationTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DestinationType::class);
    }

    public function add(DestinationType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DestinationType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
