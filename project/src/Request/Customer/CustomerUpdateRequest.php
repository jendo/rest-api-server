<?php

declare(strict_types=1);

namespace App\Request\Customer;

use Symfony\Component\Validator\Constraints as Assert;

class CustomerUpdateRequest
{
    #[Assert\Length(min: 2, max: 50)]
    public ?string $firstName = null;

    #[Assert\Length(min: 2, max: 50)]
    public ?string $lastName = null;
}
