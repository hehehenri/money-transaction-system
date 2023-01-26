<?php

namespace Src\Ledger\Application;

use Src\Ledger\Domain\DTOs\LedgerDTO;
use Src\Ledger\Domain\Entities\Ledger;
use Src\Ledger\Domain\Repository\LedgerRepository;

class CreateLedger
{
    public function __construct(public readonly LedgerRepository $repository)
    {
    }

    public function create(LedgerDTO $dto): Ledger
    {
        return $this->repository->create($dto);
    }
}
