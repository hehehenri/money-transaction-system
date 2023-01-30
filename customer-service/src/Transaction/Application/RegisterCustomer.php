<?php

namespace Src\Transaction\Application;

use GuzzleHttp\Exception\GuzzleException;
use Src\Customer\Domain\Entities\Customer;
use Src\Infrastructure\Clients\Http\Exceptions\ExternalServiceException;
use Src\Infrastructure\Clients\Http\TransactionsService\Endpoint;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ClientException;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ResourceNotFoundException;
use Src\Infrastructure\Clients\Http\TransactionsService\Payloads\RegisterCustomerPayload;
use Src\Infrastructure\Clients\Http\TransactionsService\TransactionsServiceClient;

class RegisterCustomer
{
    public function __construct(private readonly TransactionsServiceClient $client)
    {
    }

    /**
     * @throws GuzzleException
     * @throws ExternalServiceException
     * @throws ResourceNotFoundException
     * @throws ClientException
     */
    public function intoTransactionsService(Customer $customer): void
    {
        $payload = new RegisterCustomerPayload($customer->id);

        $this->client->send(Endpoint::REGISTER_CUSTOMERS, $payload);
    }
}
