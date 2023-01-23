<?php

namespace Src\Transactions\Domain\Repositories;

use Src\Transactionables\Domain\Entities\Sender;
use Src\Transactions\Domain\DTOs\StoreTransactionDTO;
use Src\Transactions\Domain\Entities\Transaction;

interface TransactionRepository
{
    public function store(StoreTransactionDTO $payload): Transaction;

    public function getLastSenderTransactions(Sender $sender): ?Transaction;
}
