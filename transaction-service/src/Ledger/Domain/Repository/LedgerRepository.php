<?php

namespace Src\Ledger\Domain\Repository;

use Src\Transactionables\Domain\ValueObjects\TransactionableId;

interface LedgerRepository
{
    public function lockRow(TransactionableId $id): void;
}
