<?php

namespace Src\Transactionables\Domain\Repositories;

use Src\Transactionables\Domain\DTOs\TransactionableDTO;
use Src\Transactionables\Domain\Entities\Transactionable;

interface TransactionableRepository
{
    public function register(TransactionableDTO $dto): Transactionable;
}
