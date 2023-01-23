<?php

namespace Src\Transaction\Application;

use Src\Transaction\Domain\Repositories\TransactionRepository;
use Src\Transaction\Presentation\Rest\ViewModels\StoreTransactionViewModel;

class StoreTransaction
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
        private readonly UpdateLedger $updateLedger,
    ) {
    }

    public function handle(StoreTransactionViewModel $payload)
    {
        $this->transactionRepository->store($payload);
        $this->updateLedger->handle()
    }
}
