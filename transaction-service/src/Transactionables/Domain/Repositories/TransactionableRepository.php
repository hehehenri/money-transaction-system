<?php

namespace Src\Transactionables\Domain\Repositories;

use Src\Transactionables\Domain\DTOs\TransactionableDTO;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Enums\Provider;

interface TransactionableRepository
{
    public function register(TransactionableDTO $dto): Transactionable;

    public function get(\Src\Transactionables\Domain\ValueObjects\ProviderId $providerId, Provider $provider);
}
