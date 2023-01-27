<?php

namespace Src\Transaction\Application;

use GuzzleHttp\Exception\GuzzleException;
use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Shopkeeper\Presentation\Rest\ViewModels\Transactions\SendTransactionViewModel;
use Src\Infrastructure\Clients\Http\Exceptions\ExternalServiceException;
use Src\Infrastructure\Clients\Http\TransactionsService\Endpoint;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ClientException;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ResourceNotFoundException;
use Src\Infrastructure\Clients\Http\TransactionsService\Payloads\SendTransactionPayload;
use Src\Infrastructure\Clients\Http\TransactionsService\TransactionsServiceClient;

class SendTransaction
{
    public function __construct(private readonly TransactionsServiceClient $client)
    {
    }

    /**
     * @throws GuzzleException
     * @throws ResourceNotFoundException
     * @throws ExternalServiceException
     * @throws ClientException
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function send(SendTransactionViewModel $payload, Shopkeeper $Shopkeeper): void
    {
        $payload = new SendTransactionPayload($Shopkeeper, $payload->receiver, $payload->amount);

        $this->client->send(Endpoint::SEND_TRANSACTION, $payload);
    }
}
