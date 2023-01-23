<?php

namespace Src\Transactions\Domain\Entities;

use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\Entities\Receiver;
use Src\Transactionables\Domain\Entities\Sender;
use Src\Transactions\Domain\Enums\TransactionStatus;
use Src\Transactions\Domain\ValueObjects\TransactionId;

class Transaction
{
    public function __construct(
        public readonly TransactionId $id,
        public readonly Receiver $receiver,
        public readonly Sender $sender,
        public readonly Money $amount,
        public readonly TransactionStatus $transactionStatus,
    ) {
    }
}
