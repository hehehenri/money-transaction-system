<?php

namespace Src\Infrastructure\Repositories;

use Src\Infrastructure\Models\TransactionableModel;
use Src\Infrastructure\Models\TransactionModel;
use Src\Transactionables\Domain\DTOs\TransactionableDTO;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Repositories\TransactionableRepository;

class TransactionableEloquentRepository implements TransactionableRepository
{
    public function __construct(private readonly TransactionModel $model)
    {
    }

    public function register(TransactionableDTO $dto): Transactionable
    {
        /** @var TransactionableModel $transactionable */
        $transactionable = $this->model
            ->query()
            ->create($dto->jsonSerialize());

        return $transactionable->intoEntity();
    }
}
