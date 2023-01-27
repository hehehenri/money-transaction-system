<?php

namespace Shopkeeper\Transactions;

use Mockery;
use Src\Infrastructure\Clients\Http\Exceptions\ExternalServiceException;
use Src\Infrastructure\Clients\Http\TransactionsService\Endpoint;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ResourceNotFoundException;
use Src\Infrastructure\Clients\Http\TransactionsService\Payloads\TransactionServicePayload;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetBalanceResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\TransactionsServiceClient;
use Src\Infrastructure\Models\ShopkeeperModel;
use Src\Shared\ValueObjects\Money;
use Tests\TestCase;

class GetBalanceTest extends TestCase
{
    public function testItGetsTheUserBalance(): void
    {
        /** @var ShopkeeperModel $model */
        $model = ShopkeeperModel::factory()->create();
        $Shopkeeper = $model->intoEntity();

        $client = Mockery::mock(TransactionsServiceClient::class);
        $payload = Mockery::type(TransactionServicePayload::class);
        $response = new GetBalanceResponse($Shopkeeper->id, new Money(100000));
        $client->shouldReceive('send')
            ->once()
            ->with(Endpoint::GET_BALANCE, $payload)
            ->andReturn($response);

        $this->instance(TransactionsServiceClient::class, $client);

        $response = $this->asShopkeeper($Shopkeeper)
            ->getJson(route('Shopkeeper.wallet.balance'));

        $response->assertSee(['balance' => 100000]);
    }

    public function testItReturnsNotFoundMessage(): void
    {
        /** @var ShopkeeperModel $model */
        $model = ShopkeeperModel::factory()->create();
        $Shopkeeper = $model->intoEntity();

        $client = Mockery::mock(TransactionsServiceClient::class);
        $payload = Mockery::type(TransactionServicePayload::class);
        $client->shouldReceive('send')
            ->once()
            ->with(Endpoint::GET_BALANCE, $payload)
            ->andThrow(ResourceNotFoundException::balanceNotFound($Shopkeeper->id));

        $this->instance(TransactionsServiceClient::class, $client);

        $this->asShopkeeper($Shopkeeper)
            ->getJson(route('Shopkeeper.wallet.balance'))
            ->assertNotFound()
            ->assertSee('not found');
    }

    public function testItRetursErrorMesasgeWhenTransactionsServiceIsDown()
    {
        /** @var ShopkeeperModel $model */
        $model = ShopkeeperModel::factory()->create();
        $Shopkeeper = $model->intoEntity();

        $client = Mockery::mock(TransactionsServiceClient::class);
        $payload = Mockery::type(TransactionServicePayload::class);
        $client->shouldReceive('send')
            ->once()
            ->with(Endpoint::GET_BALANCE, $payload)
            ->andThrow(ExternalServiceException::serviceUnavailable());

        $this->instance(TransactionsServiceClient::class, $client);

        $this->asShopkeeper($Shopkeeper)
            ->getJson(route('Shopkeeper.wallet.balance'))
            ->assertServerError()
            ->assertSee('Try again later.');
    }
}
