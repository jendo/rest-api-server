<?php

declare(strict_types=1);

namespace App\Utils;

use JsonException;

class Json
{
    /**
     * @throws JsonException
     */
    public static function encode(mixed $data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws JsonException
     */
    public static function decode(string $json, ?bool $associative = true): mixed
    {
        return json_decode(json: $json, associative: $associative, flags: JSON_THROW_ON_ERROR);
    }
}
