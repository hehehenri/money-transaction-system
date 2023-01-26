<?php

namespace Src\Transaction\Domain\Entities;

use Src\Transaction\Domain\ValueObjects\TransactionableId;
use Src\Transaction\Domain\ValueObjects\TransactionableType;

class Transactionable
{
    public function __construct(
        public readonly TransactionableId $id,
        public readonly TransactionableType $type,
    ) {
    }
}
