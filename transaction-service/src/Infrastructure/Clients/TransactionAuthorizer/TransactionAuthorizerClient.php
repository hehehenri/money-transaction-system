<?php

namespace Src\Infrastructure\Clients\TransactionAuthorizer;

use GuzzleHttp\Client;
use Src\Infrastructure\Clients\BaseClient;
use Src\Infrastructure\Clients\Enums\Method;
use Src\Infrastructure\Clients\Exceptions\InvalidURIException;
use Src\Infrastructure\Clients\Exceptions\RequestException;
use Src\Infrastructure\Clients\Exceptions\ResponseException;
use Src\Infrastructure\Clients\ValueObjects\URI;
use Symfony\Component\HttpFoundation\Response;

class TransactionAuthorizerClient
{
    private readonly BaseClient $client;

    public function __construct(
        Client $client,
    ) {
        $this->client = new BaseClient($client, 'transaction-authorizer');
    }

    /**
     * @throws RequestException
     * @throws InvalidURIException
     * @throws ResponseException
     */
    public function authorize(): void
    {
        /** @var string $configUri */
        $configUri = config('transactions.authorizer.uri');

        $uri = new URI($configUri);

        $statusCode = $this->client->send(Method::GET, new URI($uri))
            ->getStatusCode();

        if ($statusCode !== Response::HTTP_OK) {
            throw ResponseException::invalidStatusCode($statusCode);
        }
    }
}
