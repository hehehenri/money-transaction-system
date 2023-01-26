<?php

namespace Src\Transaction\Application;

use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Domain\ValueObjects\CustomerId;
use Src\Infrastructure\Clients\Http\TransactionsService\Endpoint;
use Src\Infrastructure\Clients\Http\TransactionsService\Payloads\GetBalancePayload;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetBalanceResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\TransactionsServiceClient;
use Src\Transaction\Domain\ValueObjects\Balance;

class GetBalance
{
    public function __construct(private readonly TransactionsServiceClient $client)
    {
    }

    public function for(Customer $customer): Balance
    {
        $payload = new GetBalancePayload($customer->id);

        /** @var GetBalanceResponse $response */
        $response = $this->client->send(Endpoint::GET_BALANCE, $payload);

        return new Balance($response->balance, $customer);
    }
}
