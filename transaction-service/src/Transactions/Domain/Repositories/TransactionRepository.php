<?php

namespace Src\Transactions\Domain\Repositories;

use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactions\Domain\DTOs\StoreTransactionDTO;
use Src\Transactions\Domain\Entities\Transaction;

interface TransactionRepository
{
    /** @throws InvalidTransactionableException */
    public function store(StoreTransactionDTO $payload): Transaction;
}
