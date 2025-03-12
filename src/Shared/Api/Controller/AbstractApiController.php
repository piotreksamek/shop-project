<?php

declare(strict_types=1);

namespace App\Shared\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Exception;
use Throwable;

abstract class AbstractApiController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly TranslatorInterface $translator,
    ) {}

    protected function successData(?string $message, mixed $data, int $response = Response::HTTP_OK): JsonResponse
    {
        return $this->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $response);
    }

    /** @param array<int, string> $errors */
    protected function successKnownIssueMessage(Exception $exception, array $errors = []): JsonResponse
    {
        return $this->json([
            'status' => 'error',
            'errors' => $errors,
            'message' => $this->translator->trans($exception->getPrevious()->getMessage(), [], 'exceptions'),
        ], Response::HTTP_OK);
    }

    /** @param array<string, string> $errors */
    protected function errors(array $errors, ?Throwable $throwable = null): JsonResponse
    {
        return $this->json([
            'response' => false,
            'errors' => [
                'date' => new \DateTimeImmutable(),
                'message' => $this->translator->trans($throwable->getMessage(), [], 'exceptions'),
                $errors,
            ],
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param array<string, mixed> $headers
     * @param array<string, mixed> $context
     */
    private function json(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        $json = $this->serializer->serialize($data, 'json', array_merge([
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
        ], $context));

        return new JsonResponse($json, $status, $headers, true);
    }
}
