<?php

namespace Src\Infrastructure\Repositories;

use Src\Infrastructure\Models\TransactionModel;
use Src\Infrastructure\ValueObjects\Paginator;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactions\Domain\DTOs\StoreTransactionDTO;
use Src\Transactions\Domain\Entities\Transaction;
use Src\Transactions\Domain\Enums\TransactionStatus;
use Src\Transactions\Domain\Repositories\TransactionRepository;
use Src\Transactions\Domain\ValueObjects\TransactionId;

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

    public function updateStatus(Transaction $transaciton, TransactionStatus $status): void
    {
        $this->model
            ->query()
            ->where('id', $transaciton->id)
            ->update(['status' => $status->value]);
    }

    /** @throws InvalidTransactionableException */
    public function findById(TransactionId $id): ?Transaction
    {
        /** @var ?TransactionModel $transactionModel */
        $transactionModel = $this->model
            ->query()
            ->where('id', (string) $id)
            ->first();

        return $transactionModel?->intoEntity();
    }

    public function getPaginated(Transactionable $transactionable, int $page = 1, int $perPage = 15): Paginator
    {
        $paginated = $this->model
            ->query()
            ->where('sender_id')
            ->orWhere('receiver_id')
            ->paginate(15, page: $page);

        return new Paginator(
            $paginated->items(),
            $paginated->total(),
            $paginated->perPage()
        );
    }
}
