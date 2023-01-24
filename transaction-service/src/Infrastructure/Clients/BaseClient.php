<?php

namespace Src\Infrastructure\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Src\Infrastructure\Clients\CircuitBreaker\CircuitBreaker;
use Src\Infrastructure\Clients\Enums\Method;
use Src\Infrastructure\Clients\Exceptions\RequestException;
use Src\Infrastructure\Clients\Exceptions\ResponseException;
use Src\Infrastructure\Clients\ValueObjects\URI;

abstract class BaseClient
{
    private CircuitBreaker $circuitBreaker;

    public function __construct(
        private readonly Client $client,
    ) {
        $this->circuitBreaker = new CircuitBreaker(get_class($this));
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
