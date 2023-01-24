<?php

namespace Src\Infrastructure\Repositories;

use Src\Infrastructure\Models\LedgerModel;
use Src\Ledger\Domain\Repository\LedgerRepository;
use Src\Transactionables\Domain\ValueObjects\TransactionableId;

class LedgerEloquentRepository implements LedgerRepository
{
    public function __construct(private readonly LedgerModel $model)
    {
    }

    public function lockRow(TransactionableId $id): void
    {
        $this->model
            ->query()
            ->where('transactionable_id', $id)
            ->lockForUpdate()
            ->get();
    }
}
