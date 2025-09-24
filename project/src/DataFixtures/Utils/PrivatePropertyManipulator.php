<?php

declare(strict_types=1);

namespace App\DataFixtures\Utils;

use InvalidArgumentException;
use ReflectionClass;

final class PrivatePropertyManipulator
{
    public static function patchProperty(object $object, string $property, mixed $value): void
    {
        $reflection = new ReflectionClass($object);

        do {
            if ($reflection->hasProperty($property)) {
                $reflectionProperty = $reflection->getProperty($property);
                $reflectionProperty->setValue($object, $value);

                return;
            }

            $reflection = $reflection->getParentClass();
        } while (false !== $reflection);

        throw new InvalidArgumentException(
            sprintf(
                'Property `%s` does not exist in class `%s` or any of its parent classes.',
                $property,
                $object::class
            )
        );
    }
}
