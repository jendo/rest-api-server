<?php

declare(strict_types=1);

namespace App\Entity\CustomerLog;

use App\Entity\Customer\Customer;
use App\Repository\CustomerLog\CustomerLogRepository;
use App\Traits\EntityIdTrait;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: CustomerLogRepository::class)]
#[ORM\Table(name: 'customer_log')]
class CustomerLog
{
    use EntityIdTrait;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Customer $customer;

    #[ORM\Column(name: 'action', type: 'customer_log_action_type', length: 50)]
    private CustomerLogAction $action;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private DateTimeImmutable $createdAt;

    private function __construct(
        Customer $customer,
        CustomerLogAction $action,
        DateTimeImmutable $createdAt
    ) {
        $this->id = Uuid::uuid4();
        $this->customer = $customer;
        $this->action = $action;
        $this->createdAt = $createdAt;
    }

    public static function createCreatedLog(
        Customer $customer,
        DateTimeImmutable $createdAt
    ): self {
        return new self(
            $customer,
            CustomerLogAction::CREATED(),
            $createdAt
        );
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getAction(): CustomerLogAction
    {
        return $this->action;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
