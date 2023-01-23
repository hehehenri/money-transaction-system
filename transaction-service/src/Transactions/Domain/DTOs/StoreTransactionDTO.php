<?php

namespace Src\Transactions\Domain\DTOs;

use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\Entities\Receiver;
use Src\Transactionables\Domain\Entities\Sender;
use Src\Transactions\Domain\Enums\TransactionStatus;

class StoreTransactionDTO
{
    public function __construct(
        private readonly Sender $sender,
        private readonly Receiver $receiver,
        private readonly Money $amount,
    ) {
    }

    /** @return array<string, string|int> */
    public function jsonSerialize(): array
    {
        return [
            'sender_id' => (string) $this->sender->id,
            'receiver_id' => (string) $this->receiver->id,
            'amount' => $this->amount->value(),
            'status' => TransactionStatus::PENDING->value,
        ];
    }
}
