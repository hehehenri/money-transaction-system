<?php

namespace Src\Infrastructure\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Src\Infrastructure\Clients\CircuitBreaker\CircuitBreaker;
use Src\Infrastructure\Clients\Enums\Method;
use Src\Infrastructure\Clients\Exceptions\RequestException;
use Src\Infrastructure\Clients\ValueObjects\URI;
use Src\Infrastructure\Clients\Exceptions\ResponseException;

abstract class BaseClient
{
    public function __construct(private readonly Client $client, protected readonly CircuitBreaker $circuitBreaker)
    {
    }

    /**
     * @throws RequestException
     * @throws ResponseException
     */
    protected function send(Method $method, URI $uri): ResponseInterface
    {
        if (! $this->circuitBreaker->isAvailable()) {
            throw RequestException::serviceIsUnavailable();
        }

        try {
            $response = $this->client->request($method->value, (string) $uri);
        } catch (GuzzleException) {
            $this->circuitBreaker->handleFailure();

            throw ResponseException::internalServerError();
        }

        $this->circuitBreaker->handleSuccess();

        return $response;
    }
}
