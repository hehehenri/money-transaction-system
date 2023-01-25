<?php

namespace Src\Infrastructure\Clients\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Src\Infrastructure\Clients\CircuitBreaker\CircuitBreaker;
use Src\Infrastructure\Clients\Http\Enums\Method;
use Src\Infrastructure\Clients\Http\Exceptions\RequestException;
use Src\Infrastructure\Clients\Http\Exceptions\ResponseException;
use Src\Infrastructure\Clients\Http\ValueObjects\BaseUrl;
use Src\Infrastructure\Clients\Http\ValueObjects\Body;
use Src\Infrastructure\Clients\Http\ValueObjects\URI;

class BaseClient
{
    private CircuitBreaker $circuitBreaker;

    private readonly Client $client;

    public function __construct(
        BaseUrl $baseUrl,
        string $service,
    ) {
        $this->client = new Client(['base_url' => $baseUrl]);

        $this->circuitBreaker = new CircuitBreaker($service);
    }

    /**
     * @throws RequestException
     * @throws ResponseException
     */
    public function send(Method $method, URI $uri, ?Body $body): ResponseInterface
    {
        if (! $this->circuitBreaker->isAvailable()) {
            throw RequestException::serviceIsUnavailable();
        }

        try {
            $request = new Request($method->value, (string) $uri, body: $body?->jsonSerialize());

            $response = $this->client->send($request);
        } catch (GuzzleException) {
            $this->circuitBreaker->handleFailure();

            throw ResponseException::internalServerError();
        }

        $this->circuitBreaker->handleSuccess();

        return $response;
    }
}
