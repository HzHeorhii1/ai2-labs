<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\Measurement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Measurement>
 */
class MeasurementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Measurement::class);
    }

    public function findByLocation(Location $location): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.location = :location')
            ->andWhere('m.date >= :today')
            ->setParameter('location', $location)
            ->setParameter('today', (new \DateTime())->format('Y-m-d'))
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
