<?php

namespace Tests\Feature\Transactions;

use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Src\Infrastructure\Models\LedgerModel;
use Src\Infrastructure\Models\TransactionableModel;
use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\DTOs\TransactionableDTO;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactionables\Domain\ValueObjects\ProviderId;
use Tests\TestCase;

class StoreTransactionsTest extends TestCase
{
    /**
     * @dataProvider validPayload
     *
     * @throws InvalidTransactionableException
     */
    public function testCanStoreTransactions(TransactionableDTO $sender, TransactionableDTO $receiver, Money $money): void
    {
        /** @var TransactionableModel $senderModel */
        $senderModel = TransactionableModel::factory($sender->jsonSerialize())->create();
        /** @var TransactionableModel $receiverModel */
        $receiverModel = TransactionableModel::factory($receiver->jsonSerialize())->create();

        $sender = $senderModel->intoEntity()->asSender();
        $receiver = $receiverModel->intoEntity()->asReceiver();

        $this->giveMoney($sender, $money);

        $response = $this->route([
            'sender_provider_id' => (string) $sender->providerId,
            'sender_provider_name' => $sender->provider->value,
            'receiver_provider_id' => (string) $receiver->providerId,
            'receiver_provider_name' => $receiver->provider->value,
            'amount' => $money->value(),
        ]);

        $response->assertOk();
    }

    public function testTransactionIsRefusedWhenValidatorIsOffline()
    {

    }

    public function testTransactionableMustExist(): void
    {
        $response = $this->route([
            'sender_provider_id' => Str::uuid()->toString(),
            'sender_provider_name' => Provider::CUSTOMERS->value,
            'receiver_provider_id' => Str::uuid()->toString(),
            'receiver_provider_name' => Provider::SHOPKEEPERS->value,
            'amount' => 15000,
        ]);

        $response->assertUnprocessable()
            ->assertSee('not found');
    }

    public function testShopkeepersCantSendTransactions(): void
    {
        $sender = new TransactionableDTO(
            new ProviderId(Str::uuid()->toString()),
            Provider::SHOPKEEPERS
        );

        /** @var TransactionableModel $sender */
        $sender = TransactionableModel::factory($sender->jsonSerialize())->create();

        $money = new Money(15000);

        $this->giveMoney($sender->intoEntity(), $money);

        $response = $this->route([
            'sender_provider_id' => $sender->provider_id,
            'sender_provider_name' => $sender->provider,
            'receiver_provider_id' => Str::uuid()->toString(),
            'receiver_provider_name' => Provider::CUSTOMERS->value,
            'amount' => $money->value(),
        ]);

        $response->assertUnprocessable()
            ->assertSee('cannot send transactions');
    }

    /**
     * @return array<string, array<TransactionableDTO|Money>>
     */
    public function validPayload(): array
    {
        return [
            'from_customer_to_shopkeeper' => [
                new TransactionableDTO(new ProviderId(Str::uuid()->toString()), Provider::CUSTOMERS),
                new TransactionableDTO(new ProviderId(Str::uuid()->toString()), Provider::SHOPKEEPERS),
                new Money(15000),
            ],
            'from_customer_to_customer' => [
                new TransactionableDTO(new ProviderId(Str::uuid()->toString()), Provider::CUSTOMERS),
                new TransactionableDTO(new ProviderId(Str::uuid()->toString()), Provider::CUSTOMERS),
                new Money(20000),
            ],
        ];
    }

    /** @param  array<string, string>  $payload */
    private function route(array $payload): TestResponse
    {
        return $this->postJson(route('transaction.store'), $payload);
    }

    private function giveMoney(Transactionable $transactionable, Money $money)
    {
        LedgerModel::factory([
            'transactionable_id' => $transactionable->id,
            'amount' => $money->value(),
        ])->create();
    }
}
