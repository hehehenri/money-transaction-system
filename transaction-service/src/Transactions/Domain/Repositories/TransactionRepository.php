<?php

namespace Src\Transaction\Domain\Repositories;

use Src\Transaction\Presentation\Rest\ViewModels\StoreTransactionViewModel;
use Src\Transactions\Domain\Entities\Transaction;

interface TransactionRepository
{
    public function store(StoreTransactionViewModel $payload): Transaction;
}
