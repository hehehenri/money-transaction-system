<?php

namespace Src\Infrastructure\Repositories;

use Src\Infrastructure\Models\TransactionableModel;
use Src\Transactionables\Domain\DTOs\TransactionableDTO;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\Repositories\TransactionableRepository;
use Src\Transactionables\Domain\ValueObjects\ProviderId;

class TransactionableEloquentRepository implements TransactionableRepository
{
    public function __construct(private readonly TransactionableModel $model)
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

    public function get(ProviderId $providerId, Provider $provider): ?Transactionable
    {
        /** @var ?TransactionableModel $transactionable */
        $transactionable = $this->model
            ->query()
            ->where('provider_id', (string) $providerId)
            ->where('provider', $provider->value)
            ->first();

        return $transactionable?->intoEntity();
    }
}
