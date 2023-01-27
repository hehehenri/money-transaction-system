<?php

namespace Src\Transaction\Application;

use GuzzleHttp\Exception\GuzzleException;
use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Presentation\Rest\ViewModels\Transactions\SendTransactionViewModel;
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
    public function send(SendTransactionViewModel $payload, Customer $customer): void
    {
        $payload = new SendTransactionPayload($customer, $payload->receiver, $payload->amount);

        $this->client->send(Endpoint::SEND_TRANSACTION, $payload);
    }
}
