<?php

namespace Src\Transactions\Domain\Repositories;

use Src\Shared\Constraints\Paginator;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactions\Domain\DTOs\StoreTransactionDTO;
use Src\Transactions\Domain\Entities\Transaction;
use Src\Transactions\Domain\Enums\TransactionStatus;
use Src\Transactions\Domain\ValueObjects\TransactionId;

interface TransactionRepository
{
    /** @throws InvalidTransactionableException */
    public function store(StoreTransactionDTO $payload): Transaction;

    public function updateStatus(Transaction $transaciton, TransactionStatus $status): void;

    /** @throws InvalidTransactionableException */
    public function findById(TransactionId $id): ?Transaction;

    public function getPaginated(Transactionable $transactionable, int $page, int $perPage): Paginator;
}
