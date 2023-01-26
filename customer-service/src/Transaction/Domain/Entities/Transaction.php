<?php

namespace Src\Transaction\Domain\Entities;

use Src\Customer\Domain\Entities\Customer;
use Src\Shared\ValueObjects\Money;
use Src\Transaction\Domain\ValueObjects\TransactionType;

class Transaction
{
    public function __construct(
        public readonly Money $money,
        public readonly Customer $customer,
        public readonly TransactionType $type,
        public readonly Transactionable $transactionable,
    ) {
    }
}
