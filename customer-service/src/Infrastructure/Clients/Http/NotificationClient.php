<?php

namespace Src\Infrastructure\Clients\Http;

use GuzzleHttp\Client;
use Src\Infrastructure\Clients\Http\Enums\Method;
use Src\Infrastructure\Clients\Http\Exceptions\InvalidURIException;
use Src\Infrastructure\Clients\Http\Exceptions\RequestException;
use Src\Infrastructure\Clients\Http\Exceptions\ResponseException;
use Src\Infrastructure\Clients\Http\ValueObjects\URI;
use Src\Transactionables\Domain\Entities\Transactionable;
use Symfony\Component\HttpFoundation\Response;

class NotificationClient
{
    private readonly BaseClient $client;

    public function __construct(Client $client)
    {
        $this->client = new BaseClient($client, 'notification-service');
    }

    /**
     * @throws RequestException
     * @throws InvalidURIException
     * @throws ResponseException
     */
    public function send(Transactionable $transactionable): void
    {
        /** @var string $configUri */
        $configUri = config('transactions.notification.service_uri');

        $uri = new URI($configUri);

        $statusCode = $this->client->send(Method::GET, new URI($uri))
            ->getStatusCode();

        if ($statusCode !== Response::HTTP_OK) {
            throw ResponseException::invalidStatusCode($statusCode);
        }
    }
}
