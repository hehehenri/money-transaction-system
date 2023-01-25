<?php

namespace Src\Infrastructure\Repositories;

use Src\Infrastructure\Models\LedgerModel;
use Src\Ledger\Domain\Entities\Ledger;
use Src\Ledger\Domain\Repository\LedgerRepository;
use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\Entities\Transactionable;
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

    public function addMoney(TransactionableId $id, Money $balance): void
    {
        $this->model->query()->increment('amount', $balance->value());
    }

    public function subMoney(TransactionableId $id, Money $balance): void
    {
        $this->model->query()->decrement('amount', $balance->value());
    }

    public function getByTransactionable(Transactionable $transactionable): ?Ledger
    {
        /** @var ?LedgerModel $ledger */
        $ledger = $this->model
            ->query()
            ->where('transactionable_id', $transactionable->id)
            ->first();

        return $ledger?->intoEntity();
    }
}
