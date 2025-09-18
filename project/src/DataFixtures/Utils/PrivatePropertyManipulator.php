<?php

declare(strict_types=1);

namespace App\DataFixtures\Utils;

use Exception;
use ReflectionClass;

final class PrivatePropertyManipulator
{
    public static function patchProperty(&$object, $property, $value): void
    {
        $reflection = new ReflectionClass($object);

        do {
            if ($reflection->hasProperty($property)) {
                $reflectionProperty = $reflection->getProperty($property);
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($object, $value);
                $reflectionProperty->setAccessible(false);

                return;
            }

            $reflection = $reflection->getParentClass();
        } while (false !== $reflection);

        throw new Exception(sprintf("Error while patching '%s' on class %s", $property, $object::class));
    }

    public static function patchProperties(&$object, $propertyValueTuples): void
    {
        foreach ($propertyValueTuples as $property => $value) {
            self::patchProperty($object, $property, $value);
        }
    }

    public static function getProperty(&$object, $property)
    {
        $reflection = new ReflectionClass($object);

        do {
            if ($reflection->hasProperty($property)) {
                $reflectionProperty = $reflection->getProperty($property);
                $reflectionProperty->setAccessible(true);

                return $reflectionProperty->getValue($object);
            }

            $reflection = $reflection->getParentClass();
        } while (false !== $reflection);

        throw new Exception(sprintf("Error while getting '%s' on class %s", $property, $object::class));
    }
}
