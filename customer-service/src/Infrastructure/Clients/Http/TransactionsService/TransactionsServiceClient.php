<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService;

use Src\Infrastructure\Clients\Http\BaseClient;
use Src\Infrastructure\Clients\Http\Exceptions\InvalidURLException;
use Src\Infrastructure\Clients\Http\Exceptions\RequestException;
use Src\Infrastructure\Clients\Http\Exceptions\ResponseException;
use Src\Infrastructure\Clients\Http\TransactionsService\Payloads\TransactionServicePayload;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\Response;
use Src\Infrastructure\Clients\Http\ValueObjects\URL;

class TransactionsServiceClient extends BaseClient
{
    /** @throws InvalidURLException */
    public function baseUrl(): URL
    {
        /** @var string $transactionsUrl */
        $transactionsUrl = config('services.transactions.base_url');

        return new URL($transactionsUrl);
    }

    /**
     * @throws RequestException
     * @throws ResponseException
     * @throws InvalidURLException
     */
    public function send(Endpoint $endpoint, TransactionServicePayload $payload): Response
    {
        $url = URL::build($endpoint->method(), $this->baseUrl(), $payload);

        $response = parent::sendRequest($endpoint->method(), $url, $payload);

        return $endpoint->deserializeResponse($response);
    }

    public function serviceName(): string
    {
        /** @var string $serviceName */
        $serviceName = config('services.transactions.service_name');

        return $serviceName;
    }
}
