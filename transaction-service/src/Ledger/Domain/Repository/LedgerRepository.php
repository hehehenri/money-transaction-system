<?php

namespace Src\Ledger\Domain\Repository;

use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\ValueObjects\TransactionableId;

interface LedgerRepository
{
    public function lockRow(TransactionableId $id): void;

    public function addMoney(TransactionableId $id, Money $amount): void;

    public function subMoney(TransactionableId $id, Money $amount): void;
}
