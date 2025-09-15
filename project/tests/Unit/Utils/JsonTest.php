<?php

declare(strict_types=1);

namespace App\Tests\Unit\Utils;

use App\Utils\Json;
use Generator;
use JsonException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    public static function validValuesDataProvider(): Generator
    {
        yield 'integer' => [
            'value' => 1,
            'json' => '1',
        ];

        yield 'string' => [
            'value' => 'foo',
            'json' => '"foo"',
        ];

        yield 'float' => [
            'value' => 1.2,
            'json' => '1.2',
        ];

        yield 'array' => [
            'value' => [1, 2, 3],
            'json' => '[1,2,3]',
        ];

        yield 'associative array' => [
            'value' => [
                'foo' => 1,
                'bar' => 2,
            ],
            'json' => '{"foo":1,"bar":2}',
        ];

        yield 'null' => [
            'value' => null,
            'json' => 'null',
        ];
    }


    /**
     * @dataProvider validValuesDataProvider
     *
     * @param mixed $value
     * @param string $json
     * @return void
     */
    public function testEncode(
        mixed $value,
        string $json
    ): void {
        try {
            self::assertSame($json, Json::encode($value));
        } catch (JsonException $e) {
            self::fail('Exception not expected');
        }
    }

    public static function encodeInvalidValuesDataProvider(): Generator
    {
        yield 'malformed UTF' => [
            'value' => "bad utf\xFF",
            'jsonErrorCode' => JSON_ERROR_UTF8,
        ];
        yield 'NaN' => [
            'value' => NAN,
            'jsonErrorCode' => JSON_ERROR_INF_OR_NAN,
        ];
    }

    /**
     * @dataProvider encodeInvalidValuesDataProvider
     *
     * @param mixed $value
     * @param int $jsonErrorCode
     * @return void
     */
    public function testEncodeInvalidValue(
        mixed $value,
        int $jsonErrorCode
    ): void {
        try {
            Json::encode($value);
            self::fail('Exception expected');
        } catch (JsonException $e) {
            self::assertSame($jsonErrorCode, $e->getCode());
        }
    }

    /**
     * @dataProvider validValuesDataProvider
     *
     * @param mixed $value
     * @param string $json
     */
    public function testDecode(
        mixed $value,
        string $json
    ): void {
        try {
            self::assertSame($value, Json::decode($json));
        } catch (JsonException $e) {
            self::fail('Exception not expected');
        }
    }

    public static function invalidJsonDataProvider(): Generator
    {
        yield 'empty string' => [
            'json' => '',
            'jsonErrorCode' => JSON_ERROR_SYNTAX,
        ];

        yield 'NULL' => [
            'json' => 'NULL',
            'jsonErrorCode' => JSON_ERROR_SYNTAX,
        ];

        yield 'control character' => [
            'json' => "\x00",
            'jsonErrorCode' => JSON_ERROR_CTRL_CHAR,
        ];

        yield 'malformed UTF' => [
            'json' => "\"\xC1\xBF\"",
            'jsonErrorCode' => JSON_ERROR_UTF8,
        ];
    }

    /**
     * @dataProvider invalidJsonDataProvider
     *
     * @param string $json
     * @param int $jsonErrorCode
     */
    public function testDecodeInvalidValue(
        string $json,
        int $jsonErrorCode
    ): void {
        try {
            Json::decode($json);
            self::fail('Exception expected');
        } catch (JsonException $e) {
            self::assertSame($jsonErrorCode, $e->getCode());
        }
    }
}
