<?php

declare(strict_types=1);

namespace App\Request\Customer;

use Symfony\Component\Validator\Constraints as Assert;

class CustomerCreateRequest
{
    #[Assert\NotBlank]
    public string $firstName;

    #[Assert\NotBlank]
    public string $lastName;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;
}
