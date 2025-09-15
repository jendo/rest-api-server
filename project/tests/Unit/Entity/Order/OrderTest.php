<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity\Order;

use App\Entity\Customer\Customer;
use App\Entity\Order\Order;
use App\Entity\Order\OrderAddress;
use App\Entity\Order\OrderStatus;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class OrderTest extends TestCase
{
    public function testCreate(): void
    {
        $customer = new Customer(
            'john.doe@mail.com',
            'John',
            'Doe'
        );

        $shippingAddress = new OrderAddress(
            '123 Main St',
            'New York',
            '10001',
            'USA'
        );

        $items = [
            [
                'product_id' => 1,
                'quantity' => 10,
            ],
            [
                'product_id' => 2,
                'quantity' => 20,
            ],
        ];

        $order = Order::createNew(
            $customer,
            $shippingAddress,
            $items
        );

        self::assertTrue((new ReflectionClass(Order::class))->hasMethod('getId'));
        self::assertSame($customer, $order->getCustomer());
        self::assertSame($shippingAddress, $order->getShippingAddress());
        self::assertSame(OrderStatus::PENDING, $order->getStatus()->getValue());
        self::assertSame($items, $order->getItems());
    }
}
