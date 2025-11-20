<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function findByCityAndCountry(string $city, ?string $country = null): ?Location
    {
        $qb = $this->createQueryBuilder('l')
            ->where('LOWER(l.city) = LOWER(:city)')
            ->setParameter('city', $city);

        if ($country) {
            $qb->andWhere('UPPER(l.country) = UPPER(:country)')
                ->setParameter('country', $country);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }
}
