<?php

namespace Src\Infrastructure\Repositories;

use Src\Infrastructure\Models\TransactionModel;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactions\Domain\DTOs\StoreTransactionDTO;
use Src\Transactions\Domain\Entities\Transaction;
use Src\Transactions\Domain\Repositories\TransactionRepository;

class TransactionEloquentRepository implements TransactionRepository
{
    public function __construct(private readonly TransactionModel $model)
    {
    }

    /** @throws InvalidTransactionableException */
    public function store(StoreTransactionDTO $payload): Transaction
    {
        /** @var TransactionModel $transaction */
        $transaction = $this->model
            ->query()
            ->create($payload->jsonSerialize());

        return $transaction->intoEntity();
    }
}
