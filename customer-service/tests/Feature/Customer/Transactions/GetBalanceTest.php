<?php

namespace Customer\Transactions;

use Mockery;
use Src\Infrastructure\Clients\Http\Exceptions\ExternalServiceException;
use Src\Infrastructure\Clients\Http\TransactionsService\Endpoint;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ResourceNotFoundException;
use Src\Infrastructure\Clients\Http\TransactionsService\Payloads\TransactionServicePayload;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetBalanceResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\TransactionsServiceClient;
use Src\Infrastructure\Models\CustomerModel;
use Src\Shared\ValueObjects\Money;
use Tests\TestCase;

class GetBalanceTest extends TestCase
{
    public function testItGetsTheUserBalance(): void
    {
        /** @var CustomerModel $model */
        $model = CustomerModel::factory()->create();
        $customer = $model->intoEntity();

        $client = Mockery::mock(TransactionsServiceClient::class);
        $payload = Mockery::type(TransactionServicePayload::class);
        $response = new GetBalanceResponse($customer->id, new Money(100000));
        $client->shouldReceive('send')
            ->once()
            ->with(Endpoint::GET_BALANCE, $payload)
            ->andReturn($response);

        $this->instance(TransactionsServiceClient::class, $client);

        $response = $this->asCustomer($customer)
            ->getJson(route('customer.wallet.balance'));

        $response->assertSee(['balance' => 100000]);
    }

    public function testItReturnsNotFoundMessage(): void
    {
        /** @var CustomerModel $model */
        $model = CustomerModel::factory()->create();
        $customer = $model->intoEntity();

        $client = Mockery::mock(TransactionsServiceClient::class);
        $payload = Mockery::type(TransactionServicePayload::class);
        $client->shouldReceive('send')
            ->once()
            ->with(Endpoint::GET_BALANCE, $payload)
            ->andThrow(ResourceNotFoundException::balanceNotFound($customer->id));

        $this->instance(TransactionsServiceClient::class, $client);

        $this->asCustomer($customer)
            ->getJson(route('customer.wallet.balance'))
            ->assertNotFound()
            ->assertSee('not found');
    }

    public function testItRetursErrorMesasgeWhenTransactionsServiceIsDown()
    {
        /** @var CustomerModel $model */
        $model = CustomerModel::factory()->create();
        $customer = $model->intoEntity();

        $client = Mockery::mock(TransactionsServiceClient::class);
        $payload = Mockery::type(TransactionServicePayload::class);
        $client->shouldReceive('send')
            ->once()
            ->with(Endpoint::GET_BALANCE, $payload)
            ->andThrow(ExternalServiceException::serviceUnavailable());

        $this->instance(TransactionsServiceClient::class, $client);

        $this->asCustomer($customer)
            ->getJson(route('customer.wallet.balance'))
            ->assertServerError()
            ->assertSee('Try again later.');
    }
}
