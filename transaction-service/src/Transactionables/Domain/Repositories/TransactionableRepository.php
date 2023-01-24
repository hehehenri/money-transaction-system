<?php

namespace Src\Transactionables\Domain\Repositories;

use Src\Transactionables\Domain\DTOs\TransactionableDTO;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\ValueObjects\ProviderId;

interface TransactionableRepository
{
    public function register(TransactionableDTO $dto): Transactionable;

    public function get(ProviderId $providerId, Provider $provider): ?Transactionable;
}
