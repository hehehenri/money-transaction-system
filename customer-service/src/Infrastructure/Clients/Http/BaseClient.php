<?php

namespace Src\Infrastructure\Clients\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;
use Src\Infrastructure\Clients\CircuitBreaker\CircuitBreaker;
use Src\Infrastructure\Clients\Http\Constraints\RequestPayload;
use Src\Infrastructure\Clients\Http\Enums\Method;
use Src\Infrastructure\Clients\Http\Exceptions\ExternalServiceException;
use Src\Infrastructure\Clients\Http\Exceptions\RequestException;
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
     * @throws ExternalServiceException
     * @throws ClientException
     * @throws GuzzleException
     */
    protected function sendRequest(Method $method, URL $url, RequestPayload $payload): ResponseInterface
    {
        if (! $this->circuitBreaker->isAvailable()) {
            throw ExternalServiceException::serviceUnavailable();
        }

        try {
            $response = $this->request($method, $url, $payload);
        } catch (\InvalidArgumentException $e) {
            throw RequestException::invalidFormat($e);
        } catch (ServerException) {
            $this->circuitBreaker->handleFailure();

            throw ExternalServiceException::serviceUnavailable();
        }

        $this->circuitBreaker->handleSuccess();

        return $response;
    }

    /** @throws GuzzleException */
    private function request(Method $method, URL $url, RequestPayload $payload): ResponseInterface
    {
        /** @var int $timeout */
        $timeout = config('infrastructure.http_client.timeout');

        return match ($method) {
            Method::GET => $this->client->request($method->value, (string) $url, ['timeout' => $timeout]),
            Method::POST => $this->client->request($method->value, (string) $url, [
                'timeout' => $timeout,
                'body' => json_encode($payload) ?: [],
            ])
        };
    }
}
