<?php

namespace Src\Ledger\Domain\Entities;

use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\Entities\Transactionable;

class Ledger
{
    public function __construct(
        public readonly Transactionable $transactionable,
        public readonly Money $amount
    ) {
    }
}
