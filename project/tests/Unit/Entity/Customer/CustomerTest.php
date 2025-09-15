<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity\Customer;

use App\Entity\Customer\Customer;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class CustomerTest extends TestCase
{
    public function testCreate(): void
    {
        $email = 'john.doe@mail.com';
        $firstName = 'John';
        $lastName = 'Doe';

        $customer = new Customer(
            $email,
            $firstName,
            $lastName
        );

        self::assertTrue((new ReflectionClass(Customer::class))->hasMethod('getId'));
        self::assertSame($email, $customer->getEmail());
        self::assertSame($firstName, $customer->getFirstName());
        self::assertSame($lastName, $customer->getLastName());
    }
}
