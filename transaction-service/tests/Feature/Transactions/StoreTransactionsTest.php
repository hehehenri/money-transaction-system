<?php

namespace Tests\Feature\Transactions;

use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Src\Infrastructure\Models\LedgerModel;
use Src\Infrastructure\Models\TransactionableModel;
use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\DTOs\TransactionableDTO;
use Src\Transactionables\Domain\Entities\Receiver;
use Src\Transactionables\Domain\Entities\Sender;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactionables\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\ReceiverId;
use Src\Transactionables\Domain\ValueObjects\SenderId;
use Tests\TestCase;

class StoreTransactionsTest extends TestCase
{
    /** @dataProvider validPayload */
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

    /**
     * @return array<string, array<TransactionableDTO|Money>>
     */
    public function validPayload(): array
    {
        return [
            'from_customer_to_shopkeeper' => [
                new TransactionableDTO(new ProviderId(Str::uuid()->toString()), Provider::CUSTOMERS),
                new TransactionableDTO(new ProviderId(Str::uuid()->toString()), Provider::SHOPKEEPERS),
                new Money(15000)
            ],
            'from_customer_to_customer' => [
                new TransactionableDTO(new ProviderId(Str::uuid()->toString()), Provider::CUSTOMERS),
                new TransactionableDTO(new ProviderId(Str::uuid()->toString()), Provider::CUSTOMERS),
                new Money(20000)
            ],
        ];
    }

    /**
     * @throws InvalidTransactionableException
     */
    private function getSender(Provider $provider): Sender
    {
        return new Sender(
            new SenderId(Str::uuid()->toString()),
            $provider,
            new ProviderId(Str::uuid()->toString())
        );
    }

    private function getReceiver(Provider $provider): Receiver
    {
        return new Receiver(
            new ReceiverId(Str::uuid()->toString()),
            $provider,
            new ProviderId(Str::uuid()->toString())
        );
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
            'amount' => $money->value()
        ])->create();
    }
}
