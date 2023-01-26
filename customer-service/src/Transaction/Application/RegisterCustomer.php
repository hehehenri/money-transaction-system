<?php

namespace Src\Transaction\Application;

use Src\Customer\Domain\Entities\Customer;
use Src\Infrastructure\Clients\Http\Exceptions\InvalidURLException;
use Src\Infrastructure\Clients\Http\Exceptions\RequestException;
use Src\Infrastructure\Clients\Http\Exceptions\ResponseException;
use Src\Infrastructure\Clients\Http\TransactionsService\Endpoint;
use Src\Infrastructure\Clients\Http\TransactionsService\Payloads\RegisterCustomerPayload;
use Src\Infrastructure\Clients\Http\TransactionsService\TransactionsServiceClient;

class RegisterCustomer
{
    public function __construct(private readonly TransactionsServiceClient $client)
    {
    }

    /**
     * @throws RequestException
     * @throws ResponseException
     * @throws InvalidURLException
     */
    public function handle(Customer $customer): void
    {
        $payload = new RegisterCustomerPayload($customer->id);

        $this->client->send(Endpoint::REGISTER_CUSTOMERS, $payload);
    }
}
