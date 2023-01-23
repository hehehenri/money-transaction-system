<?php

namespace Src\Infrastructure\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Src\Infrastructure\Clients\CircuitBreaker\CircuitBreaker;
use Src\Infrastructure\Clients\Enums\Method;
use Src\Infrastructure\Clients\Exceptions\RequestException;
use Src\Infrastructure\Clients\ValueObjects\JsonResponse;
use Src\Infrastructure\Clients\ValueObjects\URI;

abstract class BaseClient
{
    protected CircuitBreaker $circuitBreaker;

    public function __construct(private readonly Client $client)
    {
        $this->circuitBreaker = new CircuitBreaker();
    }

    /** @throws RequestException */
    protected function send(Method $method, URI $uri): JsonResponse
    {
        if (! $this->circuitBreaker->isAvailable()) {
            throw RequestException::serviceIsUnavailable();
        }

        try {
            $response = $this->client->request($method->value, (string) $uri);
        } catch (GuzzleException $e) {
            $this->circuitBreaker->handleFailure();

            throw RequestException::requestFailed($uri);
        }

        $this->circuitBreaker->handleSuccess();

        return JsonResponse::fromResponse($response);
    }
}
