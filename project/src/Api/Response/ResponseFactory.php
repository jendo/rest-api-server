<?php

namespace App\Api\Response;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    public const DATA_FIELD_MESSAGE = 'message';

    /**
     * @param array<string, int|string> $data
     * @param int $code
     * @param array<string, string> $headers
     * @return JsonResponse
     */
    public static function success(
        array $data = [],
        int $code = Response::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        $responseData = [];

        $responseData['status'] = 'success';

        if ([] !== $data) {
            $responseData['data'] = $data;
        }

        return new JsonResponse(
            $responseData,
            $code,
            $headers
        );
    }

    /**
     * @param string|array<int, array{message: string, ...}>|array{message: string, ...} $data
     * @param int $code
     * @param array<string, string> $headers
     * @return JsonResponse
     */
    public static function error(
        string|array $data,
        int $code = Response::HTTP_BAD_REQUEST,
        array $headers = []
    ): JsonResponse {
        if (true === is_string($data) && '' === trim($data)) {
            throw new InvalidArgumentException('Response must contain some data.');
        }

        if ([] === $data) {
            throw new InvalidArgumentException('Response must contain some data.');
        }

        if (is_string($data)) {
            $data = [[self::DATA_FIELD_MESSAGE => $data]];
        }

        if (isset($data[self::DATA_FIELD_MESSAGE])) {
            $data = [$data];
        }

        foreach ($data as $error) {
            if (false === is_array($error) || false === array_key_exists(self::DATA_FIELD_MESSAGE, $error)) {
                throw new InvalidArgumentException(sprintf('Each error must contain a `%s` field.', self::DATA_FIELD_MESSAGE));
            }
        }

        return new JsonResponse(
            [
                'status' => 'error',
                'errors' => $data,
            ],
            $code,
            $headers
        );
    }
}
