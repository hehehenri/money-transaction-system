<?php

namespace Src\Infrastructure\Clients\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Src\Infrastructure\Clients\Http\CircuitBreaker\CircuitBreaker;
use Src\Infrastructure\Clients\Http\Enums\Method;
use Src\Infrastructure\Clients\Http\Exceptions\RequestException;
use Src\Infrastructure\Clients\Http\Exceptions\ResponseException;
use Src\Infrastructure\Clients\Http\ValueObjects\URI;

class BaseClient
{
    private CircuitBreaker $circuitBreaker;

    public function __construct(
        private readonly Client $client,
        string $serviceName,
    ) {
        $this->circuitBreaker = new CircuitBreaker($serviceName);
    }

    /**
     * @throws RequestException
     * @throws ResponseException
     */
    public function send(Method $method, URI $uri): ResponseInterface
    {
        if (! $this->circuitBreaker->isAvailable()) {
            throw RequestException::serviceIsUnavailable();
        }

        try {
            $response = $this->client->request($method->value, (string) $uri);
        } catch (GuzzleException $e) {
            $this->circuitBreaker->handleFailure();

            throw ResponseException::internalServerError();
        }

        $this->circuitBreaker->handleSuccess();

        return $response;
    }
}
