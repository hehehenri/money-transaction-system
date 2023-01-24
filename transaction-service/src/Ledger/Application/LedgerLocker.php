<?php

namespace Src\Ledger\Application;

use Src\Ledger\Domain\Repository\LedgerRepository;
use Src\Transactionables\Domain\Entities\Transactionable;

class LedgerLocker
{
    public function __construct(private readonly LedgerRepository $repository)
    {
    }

    public function lock(Transactionable $transactionable): void
    {
        $this->repository->lockRow($transactionable->id);
    }
}
