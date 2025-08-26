<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use App\Entity\Order\OrderStatus;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;

class OrderStatusType extends Type
{
    public const NAME = 'order_status';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (false === $value instanceof OrderStatus) {
            throw ConversionException::conversionFailedInvalidType($value, self::NAME, [OrderStatus::class]);
        }

        return $value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): OrderStatus
    {
        if (false === is_string($value)) {
            throw ConversionException::conversionFailed($value, Types::BINARY);
        }

        return new OrderStatus($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
