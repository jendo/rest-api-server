<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use JsonException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FunctionalTestCase extends WebTestCase
{

    protected static function safeJsonEncode(mixed $data): string
    {
        try {
            $encodedJson = json_encode($data, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('Could not encode requested data.', $e->getCode(), $e);
        }

        if (false === $encodedJson) {
            throw new RuntimeException('Json encode is not possible.');
        }

        return $encodedJson;
    }

    protected static function safeJsonDecode(string $json, ?bool $associative = true): mixed
    {
        try {
            $decodedJson = json_decode(json: $json, associative: $associative, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('Could not decode requested data.', $e->getCode(), $e);
        }

        if (null === $decodedJson) {
            throw new RuntimeException('Json decode is not possible.');
        }

        return $decodedJson;
    }

    protected static function jsonDecodeResponse(KernelBrowser $client): mixed
    {
        return self::safeJsonDecode($client->getResponse()->getContent());
    }

}
