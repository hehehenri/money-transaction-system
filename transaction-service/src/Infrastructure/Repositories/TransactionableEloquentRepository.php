<?php

namespace Src\Infrastructure\Repositories;

use Src\Infrastructure\Models\TransactionableModel;
use Src\Infrastructure\Models\TransactionModel;
use Src\Transactionables\Domain\DTOs\TransactionableDTO;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\Repositories\TransactionableRepository;
use Src\Transactionables\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\TransactionableId;
use Src\Transactions\Domain\ValueObjects\TransactionId;

class TransactionableEloquentRepository implements TransactionableRepository
{
    public function __construct(
        private readonly TransactionableModel $transactionableModel,
        private readonly TransactionModel $transactionModel,
    ) {
    }

    public function register(TransactionableDTO $dto): Transactionable
    {
        /** @var TransactionableModel $transactionable */
        $transactionable = $this->transactionableModel
            ->query()
            ->create($dto->jsonSerialize());

        return $transactionable->intoEntity();
    }

    public function get(ProviderId $providerId, Provider $provider): ?Transactionable
    {
        /** @var ?TransactionableModel $transactionable */
        $transactionable = $this->transactionableModel
            ->query()
            ->where('provider_id', (string) $providerId)
            ->where('provider', $provider->value)
            ->first();

        return $transactionable?->intoEntity();
    }

    public function getSenderByTransactionId(TransactionId $id): ?Transactionable
    {
        /** @var ?TransactionModel $transaction */
        $transaction = $this->transactionModel
            ->query()
            ->whereKey((string) $id)
            ->first();

        return $transaction?->sender->intoEntity();
    }

    public function getReceiverByTransactionId(TransactionId $id): ?Transactionable
    {
        /** @var ?TransactionModel $transaction */
        $transaction = $this->transactionModel
            ->query()
            ->whereKey((string) $id)
            ->first();

        return $transaction?->receiver->intoEntity();
    }

    public function getById(TransactionableId $id): ?Transactionable
    {
        /** @var ?TransactionableModel $transactionable */
        $transactionable = $this->transactionableModel
            ->query()
            ->whereKey($id)
            ->first();

        return $transactionable?->intoEntity();
    }
}
