<?php

declare(strict_types=1);

namespace App\Event\Customer;

use App\Entity\Customer\Customer;
use Symfony\Contracts\EventDispatcher\Event;

final class CustomerUpdatedEvent extends Event
{
    public function __construct(private readonly Customer $customer)
    {
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
