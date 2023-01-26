<?php

namespace Src\Ledger\Domain\DTOs;

use Src\Transactionables\Domain\Entities\Transactionable;

class LedgerDTO
{
    public function __construct(public readonly Transactionable $transactionable)
    {
    }

    /** @return array<string, string|int> */
    public function jsonSerialize(): array
    {
        return [
            'transactionable_id' => $this->transactionable->id,
            'balance' => 0,
        ];
    }
}
