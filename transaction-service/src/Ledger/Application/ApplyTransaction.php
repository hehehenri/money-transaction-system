<?php

namespace Src\Ledger\Application;

use Illuminate\Support\Facades\DB;
use Src\Ledger\Domain\Repository\LedgerRepository;
use Src\Transactions\Domain\Entities\Transaction;

class ApplyTransaction
{
    public function __construct(private readonly LedgerRepository $repository)
    {
    }

    public function updateFromTransaction(Transaction $transaction): void
    {
        DB::transaction(function () use ($transaction) {
            $this->repository->addMoney($transaction->receiver->id, $transaction->amount);
            $this->repository->subMoney($transaction->sender->id, $transaction->amount);
        });
    }
}
