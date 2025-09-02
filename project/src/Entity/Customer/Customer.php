<?php

declare(strict_types=1);

namespace App\Entity\Customer;

use App\Entity\Order\Order;
use App\Repository\Customer\CustomerRepository;
use App\Request\Customer\CustomerCreateRequest;
use App\Traits\EntityIdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'customer')]
#[ORM\UniqueConstraint(name: 'UNIQ_CUSTOMER_EMAIL', columns: [self::COLUMN_EMAIL])]
class Customer
{
    use EntityIdTrait;

    private const EMAIL_MAX_LENGTH = 100;
    private const FIRST_NAME_MAX_LENGTH = 100;
    private const LAST_NAME_MAX_LENGTH = 100;

    public const COLUMN_EMAIL = 'email';

    #[ORM\Column(name: self::COLUMN_EMAIL, type: 'string', length: self::EMAIL_MAX_LENGTH, nullable: false)]
    private string $email;

    #[ORM\Column(name: 'first_name', type: 'string', length: self::FIRST_NAME_MAX_LENGTH, nullable: false)]
    private string $firstName;

    #[ORM\Column(name: 'last_name', type: 'string', length: self::LAST_NAME_MAX_LENGTH, nullable: false)]
    private string $lastName;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'customer')]
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

    public static function createFromRequest(
        CustomerCreateRequest $request
    ): self {
        return new self(
            $request->email,
            $request->firstName,
            $request->lastName
        );
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

    public function update(
        string $firstName,
        string $lastName
    ): void {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
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

    private function setLastName(string $lastName): void
    {
        assert(mb_strlen($lastName) <= self::LAST_NAME_MAX_LENGTH && trim($lastName) !== '');

        $this->lastName = $lastName;
    }
}
