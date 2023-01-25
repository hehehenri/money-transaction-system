<?php

namespace Src\Ledger\Domain\Repository;

use Src\Ledger\Domain\Entities\Ledger;
use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\ValueObjects\TransactionableId;

interface LedgerRepository
{
    public function lockRow(TransactionableId $id): void;

    public function addMoney(TransactionableId $id, Money $balance): void;

    public function subMoney(TransactionableId $id, Money $balance): void;

    public function getByTransactionable(Transactionable $id): ?Ledger;
}
