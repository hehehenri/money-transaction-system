<?php

namespace Src\Transactions\Application;

use Src\Transactions\Domain\Entities\Transaction;
use Src\Transactions\Domain\Enums\TransactionStatus;
use Src\Transactions\Domain\Repositories\TransactionRepository;

class UpdateTransactionStatus
{
    public function __construct(private readonly TransactionRepository $repository)
    {
    }

    public function revertTransaction(Transaction $transaction): void
    {
        $this->repository->updateStatus($transaction, TransactionStatus::REFUSED);
    }

    public function approveTransaction(Transaction $transaction): void
    {
        $this->repository->updateStatus($transaction, TransactionStatus::SUCCESS);
    }
}
