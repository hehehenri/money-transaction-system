<?php

namespace Src\Ledger\Domain\DTOs;

use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\ValueObjects\TransactionableId;

class LedgerOperationDTO
{
    public function __construct(
        public readonly TransactionableId $id,
        public readonly Money $amount
    ) {
    }
}
