<?php

namespace Src\Transaction\Domain\ValueObjects;

class Transactionable
{
    public function __construct(
        public readonly TransactionableId $id,
        public readonly TransactionableType $type,
    ) {
    }
}
