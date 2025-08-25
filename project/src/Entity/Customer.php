<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Customer
{
    private const EMAIL_MAX_LENGTH = 100;
    private const FIRST_NAME_MAX_LENGTH = 100;
    private const LAST_NAME_MAX_LENGTH = 100;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "uuid")]
    private UuidInterface $id;

    #[ORM\Column(type: "string", length: self::EMAIL_MAX_LENGTH)]
    private string $email;

    #[ORM\Column(type: "string", length: self::FIRST_NAME_MAX_LENGTH)]
    private string $firstName;

    #[ORM\Column(type: "string", length: self::LAST_NAME_MAX_LENGTH)]
    private string $lastName;

    public function __construct(string $email, string $firstName)
    {
        $this->id = Uuid::uuid4();
        $this->setEmail($email);
        $this->setFirstName($firstName);
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

    public function setLastName(string $lastName): void
    {
        assert(mb_strlen($lastName) <= self::LAST_NAME_MAX_LENGTH && trim($lastName) !== '');

        $this->lastName = $lastName;
    }
}
