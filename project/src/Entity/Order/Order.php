<?php

namespace App\Entity\Order;

use App\Entity\Customer\Customer;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: Customer::class, cascade: ["persist"], inversedBy: "orders")]
    #[ORM\JoinColumn(nullable: false)]
    private Customer $customer;

    #[ORM\OneToOne(targetEntity: OrderAddress::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private OrderAddress $shippingAddress;

    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: "order_status", length: 50)]
    private OrderStatus $status;

    /**
     * @var array<int, array{product_id: int, quantity: int}>
     */
    #[ORM\Column(type: "json")]
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
    public function createNew(
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

    public function getId(): UuidInterface
    {
        return $this->id;
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
        return new OrderStatus($this->status);
    }

    /**
     * @return array<int, array{product_id: int, quantity: int}>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
