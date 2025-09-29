<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use App\Entity\CustomerLog\CustomerLogAction;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;

class CustomerLogActionType extends Type
{
    public const NAME = 'customer_log_action_type';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (false === $value instanceof CustomerLogAction) {
            throw ConversionException::conversionFailedInvalidType($value, self::NAME, [CustomerLogAction::class]);
        }

        return $value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): CustomerLogAction
    {
        if (false === is_string($value)) {
            throw ConversionException::conversionFailed($value, Types::BINARY);
        }

        return new CustomerLogAction($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
