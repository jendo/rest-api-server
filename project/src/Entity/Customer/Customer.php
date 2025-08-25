<?php

declare(strict_types=1);

namespace App\Entity\Customer;

use App\Repository\Customer\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'customer')]
#[ORM\UniqueConstraint(name: 'UNIQ_CUSTOMER_EMAIL', columns: [self::COLUMN_EMAIL])]
class Customer
{
    private const EMAIL_MAX_LENGTH = 100;
    private const FIRST_NAME_MAX_LENGTH = 100;
    private const LAST_NAME_MAX_LENGTH = 100;

    public const COLUMN_EMAIL = 'email';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true, nullable: false)]
    private UuidInterface $id;

    #[ORM\Column(name: self::COLUMN_EMAIL, type: 'string', length: self::EMAIL_MAX_LENGTH, nullable: false)]
    private string $email;

    #[ORM\Column(name: 'first_name', type: 'string', length: self::FIRST_NAME_MAX_LENGTH, nullable: false)]
    private string $firstName;

    #[ORM\Column(name: 'last_name', type: 'string', length: self::LAST_NAME_MAX_LENGTH, nullable: false)]
    private string $lastName;

    public function __construct(
        string $email,
        string $firstName,
        string $lastName
    ) {
        $this->id = Uuid::uuid4();
        $this->setEmail($email);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
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
