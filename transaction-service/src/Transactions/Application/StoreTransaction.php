<?php

namespace Src\Transactions\Application;

use Illuminate\Support\Facades\DB;
use Src\Ledger\Application\LedgersLocker;
use Src\Ledger\Application\UpdateLedger;
use Src\Transactions\Domain\Entities\Transaction;
use Src\Transactions\Domain\Repositories\TransactionRepository;
use Src\Transactions\Presentation\Rest\ViewModels\StoreTransactionViewModel;

class StoreTransaction
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
        private readonly LedgersLocker         $locker,
        private readonly UpdateLedger          $updateLedger,
    ) {
    }

    public function handle(StoreTransactionViewModel $payload)
    {
        $this->createTransaction($payload);
    }

    private function createTransaction(StoreTransactionViewModel $payload): Transaction
    {
        DB::transaction(function () use ($payload) {
            $this->locker->lock($payload->sender, $payload->receiver);


        });
    }
}
