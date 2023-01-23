<?php

namespace Src\Transactions\Domain\Repositories;

use Src\Transactions\Presentation\Rest\ViewModels\StoreTransactionViewModel;
use Src\Transactions\Domain\Entities\Transaction;

interface TransactionRepository
{
    public function store(StoreTransactionViewModel $payload): Transaction;
}
