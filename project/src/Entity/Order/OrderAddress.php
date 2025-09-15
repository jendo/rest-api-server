<?php

declare(strict_types=1);

namespace App\Entity\Order;

use App\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
class OrderAddress
{
    use EntityIdTrait;

    private const STREET_MAX_LENGTH = 255;
    private const CITY_MAX_LENGTH = 100;
    private const POSTAL_CODE_MAX_LENGTH = 20;
    private const COUNTRY_CODE_MAX_LENGTH = 100;

    #[ORM\Column(name: 'street', type: 'string', length: self::STREET_MAX_LENGTH, nullable: false)]
    private string $street;

    #[ORM\Column(name: 'city', type: 'string', length: self::CITY_MAX_LENGTH, nullable: false)]
    private string $city;

    #[ORM\Column(name: 'postal_code', type: 'string', length: self::POSTAL_CODE_MAX_LENGTH, nullable: false)]
    private string $postalCode;

    #[ORM\Column(name: 'country', type: 'string', length: self::COUNTRY_CODE_MAX_LENGTH, nullable: false)]
    private string $country;

    public function __construct(string $street, string $city, string $postalCode, string $country)
    {
        $this->id = Uuid::uuid4();
        $this->setStreet($street);
        $this->setCity($city);
        $this->setPostalCode($postalCode);
        $this->setCountry($country);
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    private function setStreet(string $street): void
    {
        assert(mb_strlen($street) <= self::STREET_MAX_LENGTH && trim($street) !== '');

        $this->street = $street;
    }

    private function setCity(string $city): void
    {
        assert(mb_strlen($city) <= self::CITY_MAX_LENGTH && trim($city) !== '');

        $this->city = $city;
    }

    private function setPostalCode(string $postalCode): void
    {
        assert(mb_strlen($postalCode) <= self::POSTAL_CODE_MAX_LENGTH && trim($postalCode) !== '');

        $this->postalCode = $postalCode;
    }

    private function setCountry(string $country): void
    {
        assert(mb_strlen($country) <= self::COUNTRY_CODE_MAX_LENGTH && trim($country) !== '');

        $this->country = $country;
    }
}
