<?php

namespace Src\Transaction\Application;

use GuzzleHttp\Exception\GuzzleException;
use Src\Customer\Domain\Entities\Customer;
use Src\Infrastructure\Clients\Http\Exceptions\ExternalServiceException;
use Src\Infrastructure\Clients\Http\TransactionsService\Endpoint;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ClientException;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ResourceNotFoundException;
use Src\Infrastructure\Clients\Http\TransactionsService\Payloads\GetTransactionsPayload;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetTransactionsResponse\GetTransactionsResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\TransactionsServiceClient;

class GetTransactions
{
    public function __construct(private readonly TransactionsServiceClient $client)
    {
    }

    /**
     * @throws ExternalServiceException
     * @throws ClientException
     * @throws ResourceNotFoundException
     */
    public function for(Customer $customer): GetTransactionsResponse
    {
        $payload = new GetTransactionsPayload($customer->id);

        try {
            /** @var GetTransactionsResponse $response */
            $response = $this->client->send(Endpoint::GET_TRANSACTIONS, $payload);
        } catch (GuzzleException) {
            throw new ClientException();
        }

        return $response;
    }
}
