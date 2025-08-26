<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity\Order;

use App\Entity\Order\OrderAddress;
use PHPUnit\Framework\TestCase;

class OrderAddressTest extends TestCase
{
    public function testCreate(): void
    {
        $street = '123 Main St';
        $city = 'New York';
        $postalCode = '10001';
        $country = 'USA';

        $orderAddress = new OrderAddress(
            $street,
            $city,
            $postalCode,
            $country
        );

        self::assertSame($street, $orderAddress->getStreet());
        self::assertSame($city, $orderAddress->getCity());
        self::assertSame($postalCode, $orderAddress->getPostalCode());
        self::assertSame($country, $orderAddress->getCountry());
    }
}
