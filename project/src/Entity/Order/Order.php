<?php

declare(strict_types=1);

namespace App\Entity\Order;

use App\Entity\Customer\Customer;
use App\Traits\EntityIdTrait;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
class Order
{
    use EntityIdTrait;

    #[ORM\ManyToOne(targetEntity: Customer::class, cascade: ['persist'], inversedBy: 'orders')]
    #[ORM\JoinColumn(name: 'customer_id', nullable: false)]
    private Customer $customer;

    #[ORM\OneToOne(targetEntity: OrderAddress::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name:'shipping_address_id', nullable: false)]
    private OrderAddress $shippingAddress;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private DateTimeInterface $createdAt;

    #[ORM\Column(name: 'status', type: 'order_status', length: 50)]
    private OrderStatus $status;

    /**
     * @var array<int, array{product_id: int, quantity: int}>
     */
    #[ORM\Column(name: 'items', type: 'json')]
    private array $items;

    /**
     * @param Customer $customer
     * @param OrderAddress $shippingAddress
     * @param OrderStatus $status
     * @param array<int, array{product_id: int, quantity: int}> $items
     */
    private function __construct(
        Customer $customer,
        OrderAddress $shippingAddress,
        OrderStatus $status,
        array $items = []
    ) {
        $this->id = Uuid::uuid4();
        $this->customer = $customer;
        $this->shippingAddress = $shippingAddress;
        $this->status = $status;
        $this->items = $items;
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @param Customer $customer
     * @param OrderAddress $shippingAddress
     * @param array<int, array{product_id: int, quantity: int}> $items
     * @return self
     */
    public static function createNew(
        Customer $customer,
        OrderAddress $shippingAddress,
        array $items = []
    ): self {
        return new self(
            $customer,
            $shippingAddress,
            OrderStatus::PENDING(),
            $items
        );
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getShippingAddress(): OrderAddress
    {
        return $this->shippingAddress;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getStatus(): OrderStatus
    {
        return new OrderStatus($this->status->getValue());
    }

    /**
     * @return array<int, array{product_id: int, quantity: int}>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
