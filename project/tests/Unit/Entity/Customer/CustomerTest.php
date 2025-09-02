<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity\Customer;

use App\Entity\Customer\Customer;
use App\Request\Customer\CustomerCreateRequest;
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

    public function testUpdate(): void
    {
        $newFirstName = 'Johnathan';
        $newLastName = 'Doeman';

        $customer = new Customer(
            'john.doe@mail.com',
            'John',
            'Doe'
        );

        self::assertNotSame($newFirstName, $customer->getFirstName());
        self::assertNotSame($newLastName, $customer->getLastName());

        $customer->update(
            $newFirstName,
            $newLastName
        );

        self::assertSame($newFirstName, $customer->getFirstName());
        self::assertSame($newLastName, $customer->getLastName());
    }

    public function testCreateFromRequest(): void
    {
        $email = 'john.doe@mail.com';
        $firstName = 'John';
        $lastName = 'Doe';

        $request = new CustomerCreateRequest();
        $request->email = $email;
        $request->firstName = $firstName;
        $request->lastName = $lastName;

        $customer = Customer::createFromRequest($request);

        self::assertTrue((new ReflectionClass(Customer::class))->hasMethod('getId'));
        self::assertSame($email, $customer->getEmail());
        self::assertSame($firstName, $customer->getFirstName());
        self::assertSame($lastName, $customer->getLastName());
    }
}
