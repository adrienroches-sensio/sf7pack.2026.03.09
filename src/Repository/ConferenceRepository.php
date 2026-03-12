<?php

namespace App\Repository;

use App\Entity\Conference;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;

/**
 * @extends ServiceEntityRepository<Conference>
 */
class ConferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conference::class);
    }

    /**
     * @return list<Conference>
     */
    public function listAll(): array
    {
        $qb = $this->createQueryBuilder('conference');

        $qb
            ->leftJoin('conference.organizations', 'organization')
            ->addSelect('organization')

            ->leftJoin('conference.volunteerings', 'volunteering')
            ->addSelect('volunteering')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @return list<Conference>
     *
     * @throws InvalidArgumentException When both $start and $end are null. (At least one must be provided)
     */
    public function searchBetweenDates(DateTimeImmutable|null $start, DateTimeImmutable|null $end): array
    {
        if (null === $start && null === $end) {
            throw new InvalidArgumentException('At least one date must be provided');
        }

        $qb = $this->createQueryBuilder('conference');

        if (null !== $start) {
            $qb
                ->andWhere($qb->expr()->gte('conference.startAt', ':start'))
                ->setParameter('start', $start)
            ;
        }

        if (null !== $end) {
            $qb
                ->andWhere('conference.endAt <= :end')
                ->setParameter('end', $end)
            ;
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @return list<Conference>
     */
    public function searchByName(string $name): array
    {
        $qb = $this->createQueryBuilder('conference');

        $qb
            ->andWhere($qb->expr()->like('conference.name', ':name'))
            ->setParameter('name', "%{$name}%")
        ;

        return $qb->getQuery()->getResult();
    }
}
