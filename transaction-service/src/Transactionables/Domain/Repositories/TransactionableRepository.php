<?php

namespace Src\Transactionables\Domain\Repositories;

use Src\Transactionables\Domain\DTOs\TransactionableDTO;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\TransactionableId;
use Src\Transactions\Domain\ValueObjects\TransactionId;

interface TransactionableRepository
{
    public function register(TransactionableDTO $dto): Transactionable;

    public function get(ProviderId $providerId, Provider $provider): ?Transactionable;

    public function getSenderByTransactionId(TransactionId $id): ?Transactionable;

    public function getReceiverByTransactionId(TransactionId $id): ?Transactionable;

    public function getById(TransactionableId $id): ?Transactionable;
}
