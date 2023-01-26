<?php

namespace Src\Infrastructure\Clients\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Src\Infrastructure\Clients\CircuitBreaker\CircuitBreaker;
use Src\Infrastructure\Clients\Http\Constraints\RequestPayload;
use Src\Infrastructure\Clients\Http\Enums\Method;
use Src\Infrastructure\Clients\Http\Exceptions\RequestException;
use Src\Infrastructure\Clients\Http\Exceptions\ResponseException;
use Src\Infrastructure\Clients\Http\ValueObjects\URL;

abstract class BaseClient
{
    private CircuitBreaker $circuitBreaker;

    private readonly Client $client;

    public function __construct()
    {
        $this->circuitBreaker = new CircuitBreaker($this->serviceName());

        /** @var Client $client */
        $client = app(Client::class);
        $this->client = $client;
    }

    abstract public function serviceName(): string;

    /**
     * @throws RequestException
     * @throws ResponseException
     */
    protected function sendRequest(Method $method, URL $url, RequestPayload $payload): ResponseInterface
    {
        if (! $this->circuitBreaker->isAvailable()) {
            throw RequestException::serviceIsUnavailable();
        }

        try {
            $response = $this->request($method, $url, $payload);
        } catch (GuzzleException|ContainerExceptionInterface) {
            $this->circuitBreaker->handleFailure();

            throw ResponseException::internalServerError();
        }

        $this->circuitBreaker->handleSuccess();

        return $response;
    }

    /** @throws GuzzleException */
    private function request(Method $method, URL $url, RequestPayload $payload): ResponseInterface
    {
        return match ($method) {
            Method::GET => $this->client->get($url),
            Method::POST => $this->client->post($url, ['body' => json_encode($payload) ?: []])
        };
    }
}
