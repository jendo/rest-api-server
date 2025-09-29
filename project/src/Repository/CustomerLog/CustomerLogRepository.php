<?php

namespace App\Repository\CustomerLog;

use App\Entity\CustomerLog\CustomerLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerLog>
 */
class CustomerLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerLog::class);
    }

    /**
     * @param mixed $id
     * @param int|LockMode|null $lockMode
     * @phpstan-param LockMode::*|null $lockMode
     * @param int|null $lockVersion
     * @return CustomerLog|null
     */
    public function find(mixed $id, int|LockMode|null $lockMode = null, ?int $lockVersion = null): ?CustomerLog
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    /**
     * @param array<string, mixed> $criteria
     * @param array<string, 'ASC'|'asc'|'DESC'|'desc'>|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return list<CustomerLog>
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array<string, mixed> $criteria
     * @param array<string, string>|null $orderBy
     * @return CustomerLog|null
     */
    public function findOneBy(array $criteria, ?array $orderBy = null): ?CustomerLog
    {
        return parent::findOneBy($criteria, $orderBy);
    }

    /**
     * @return list<CustomerLog>
     */
    public function findAll(): array
    {
        return parent::findAll();
    }
}
