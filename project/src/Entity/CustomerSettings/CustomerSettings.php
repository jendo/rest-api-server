<?php

namespace App\Entity\CustomerSettings;

use App\Entity\Customer\Customer;
use App\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: "customer_settings")]
class CustomerSettings
{
    use EntityIdTrait;

    #[ORM\OneToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(unique: true, nullable: false)]
    private Customer $customer;

    #[ORM\Column(type: 'string', length: 2)]
    private string $preferredLanguageCode;

    #[ORM\Column(type: 'boolean')]
    private bool $marketingAllowed;

    public function __construct(Customer $customer, string $preferredLanguageCode, bool $marketingAllowed)
    {
        $this->id = Uuid::uuid4();
        $this->customer = $customer;
        $this->preferredLanguageCode = $preferredLanguageCode;
        $this->marketingAllowed = $marketingAllowed;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getPreferredLanguageCode(): string
    {
        return $this->preferredLanguageCode;
    }

    public function isMarketingAllowed(): bool
    {
        return $this->marketingAllowed;
    }
}
