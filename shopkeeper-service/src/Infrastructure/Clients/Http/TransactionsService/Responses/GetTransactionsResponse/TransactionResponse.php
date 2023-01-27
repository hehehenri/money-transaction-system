<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetTransactionsResponse;

use Src\Shared\ValueObjects\Money;
use Src\Transaction\Domain\ValueObjects\TransactionableId;
use Src\Transaction\Domain\ValueObjects\TransactionId;

class TransactionResponse
{
    public function __construct(
        public readonly TransactionId $id,
        public readonly TransactionableId $sender,
        public readonly TransactionableId $receiver,
        public readonly Money $money
    ) {
    }

    /** @return array<string, int|string> */
    public function deserialize(): array
    {
        return [
            'id' => (string) $this->id,
            'sender' => (string) $this->sender,
            'receiver' => (string) $this->receiver,
            'amount' => $this->money->value(),
        ];
    }
}
