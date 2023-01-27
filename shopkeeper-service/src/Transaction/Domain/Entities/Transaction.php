<?php

namespace Src\Transaction\Domain\Entities;

use Src\Shared\ValueObjects\Money;
use Src\Transaction\Domain\ValueObjects\Transactionable;
use Src\Transaction\Domain\ValueObjects\TransactionId;

class Transaction
{
    public function __construct(
        public readonly TransactionId $id,
        public readonly Transactionable $from,
        public readonly Transactionable $to,
        public readonly Money $amount,
    ) {
    }
}
