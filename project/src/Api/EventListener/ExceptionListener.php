<?php

declare(strict_types=1);

namespace App\Api\EventListener;

use App\Api\Response\ResponseFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof MethodNotAllowedHttpException) {
            $allowedMethods = $exception->getHeaders()['Allow'] ?? [];

            $event->setResponse(
                ResponseFactory::error(
                    sprintf('Method not allowed (Allow: %s).', $allowedMethods),
                    Response::HTTP_METHOD_NOT_ALLOWED
                )
            );
        }

        if ($exception instanceof NotFoundHttpException) {
            $event->setResponse(
                ResponseFactory::error(
                    'Resource not found.',
                    Response::HTTP_NOT_FOUND
                )
            );
        }
    }
}
