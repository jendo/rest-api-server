<?php

declare(strict_types=1);

namespace App\Entity\Customer;

use App\Entity\Order\Order;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'customer')]
#[ORM\UniqueConstraint(name: 'UNIQ_CUSTOMER_EMAIL', columns: ['email'])]
class Customer
{
    private const EMAIL_MAX_LENGTH = 100;
    private const FIRST_NAME_MAX_LENGTH = 100;
    private const LAST_NAME_MAX_LENGTH = 100;

    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private UuidInterface $id;

    #[ORM\Column(type: "string", length: self::EMAIL_MAX_LENGTH)]
    private string $email;

    #[ORM\Column(type: "string", length: self::FIRST_NAME_MAX_LENGTH)]
    private string $firstName;

    #[ORM\Column(type: "string", length: self::LAST_NAME_MAX_LENGTH)]
    private string $lastName;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: "customer")]
    private Collection $orders;

    public function __construct(
        string $email,
        string $firstName,
        string $lastName
    ) {
        $this->id = Uuid::uuid4();
        $this->setEmail($email);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->orders = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    private function setEmail(string $email): void
    {
        assert(mb_strlen($email) <= self::EMAIL_MAX_LENGTH && trim($email) !== '');

        $this->email = $email;
    }

    private function setFirstName(string $firstName): void
    {
        assert(mb_strlen($firstName) <= self::FIRST_NAME_MAX_LENGTH && trim($firstName) !== '');

        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        assert(mb_strlen($lastName) <= self::LAST_NAME_MAX_LENGTH && trim($lastName) !== '');

        $this->lastName = $lastName;
    }
}
