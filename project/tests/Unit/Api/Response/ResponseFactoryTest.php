<?php

namespace App\Tests\Unit\Api\Response;

use App\Api\Response\ResponseFactory;
use Generator;
use InvalidArgumentException;
use JsonException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactoryTest extends TestCase
{
    public static function provideValidErrorData(): Generator
    {
        yield 'data is string (single error message)' => [
            'data' => 'Something went wrong.',
            'code' => Response::HTTP_BAD_REQUEST,
            'headers' => ['x-custom-header' => 'CustomValue'],
            'expectedContent' => [
                'status' => 'error',
                'errors' => [
                    [ResponseFactory::DATA_FIELD_MESSAGE => 'Something went wrong.'],
                ],
            ],
        ];

        yield 'data is associative array with key `message`' => [
            'data' => [ResponseFactory::DATA_FIELD_MESSAGE => 'Something went wrong.'],
            'code' => Response::HTTP_BAD_REQUEST,
            'headers' => ['x-custom-header' => 'CustomValue'],
            'expectedContent' => [
                'status' => 'error',
                'errors' => [
                    [ResponseFactory::DATA_FIELD_MESSAGE => 'Something went wrong.'],
                ],
            ],
        ];

        yield 'data is associative array with key `message` and some additional key' => [
            'data' => [
                'property' => 'firstName',
                ResponseFactory::DATA_FIELD_MESSAGE => 'This value should not be blank.',
            ],
            'code' => Response::HTTP_BAD_REQUEST,
            'headers' => ['x-custom-header' => 'CustomValue'],
            'expectedContent' => [
                'status' => 'error',
                'errors' => [
                    [
                        'property' => 'firstName',
                        ResponseFactory::DATA_FIELD_MESSAGE => 'This value should not be blank.',
                    ],
                ],
            ],
        ];

        yield 'data is array of errors (each error is associative array)' => [
            'data' => [
                [
                    'property' => 'firstName',
                    ResponseFactory::DATA_FIELD_MESSAGE => 'This value should not be blank.',
                ],
                [
                    'property' => 'lastName',
                    ResponseFactory::DATA_FIELD_MESSAGE => 'This value should not be blank.',
                ]
            ],
            'code' => Response::HTTP_BAD_REQUEST,
            'headers' => ['x-custom-header' => 'CustomValue'],
            'expectedContent' => [
                'status' => 'error',
                'errors' => [
                    [
                        'property' => 'firstName',
                        ResponseFactory::DATA_FIELD_MESSAGE => 'This value should not be blank.',
                    ],
                    [
                        'property' => 'lastName',
                        ResponseFactory::DATA_FIELD_MESSAGE => 'This value should not be blank.',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideValidErrorData
     *
     * @param string|array<int, array{message: string, ...}>|array{message: string, ...} $data
     * @param int $code
     * @param array<string, string> $headers
     * @param array<string, mixed> $expectedContent
     * @return void
     * @throws JsonException
     */
    public function testCreateValidErrorResponse(
        string|array $data,
        int $code,
        array $headers,
        array $expectedContent
    ): void {
        $response = ResponseFactory::error($data, $code, $headers);

        self::assertSame($code, $response->getStatusCode());

        foreach ($headers as $header => $headerValue) {
            self::assertSame($headerValue, $response->headers->get($header));
        }

        self::assertNotFalse($response->getContent());
        self::assertSame($expectedContent, json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR));
    }

    public static function provideInvalidErrorData(): Generator
    {
        yield 'data is empty array' => [
            'data' => [],
            'expectedExceptionMessage' => 'Response must contain some data.',
        ];

        yield 'data is string with only whitespace' => [
            'data' => '  ',
            'expectedExceptionMessage' => 'Response must contain some data.',
        ];

        yield 'data is associative array without mandatory `message` key' => [
            'data' => [
                'property' => 'firstName',
            ],
            'expectedExceptionMessage' => 'Each error must contain a `message` field.',
        ];

        yield 'data is array of errors - at least one error without mandatory `message` key' => [
            'data' => [
                [
                    'property' => 'firstName',
                ],
                [
                    'property' => 'lastName',
                    ResponseFactory::DATA_FIELD_MESSAGE => 'This value should not be blank.',
                ],
            ],
            'expectedExceptionMessage' => 'Each error must contain a `message` field.',
        ];
    }

    /**
     * @dataProvider provideInvalidErrorData
     *
     * @param string|array<int, array{message: string, ...}>|array{message: string, ...} $data
     * @param string $expectedExceptionMessage
     */
    public function testErrorResponseThrowsExceptionOnInvalidData(
        string|array $data,
        string $expectedExceptionMessage
    ): void {
        try {
            ResponseFactory::error($data);

            self::fail('Expected exception');
        } catch (InvalidArgumentException $e) {
            self::assertSame($expectedExceptionMessage, $e->getMessage());
        }
    }
}
