<?php

namespace Src\Transactionables\Domain\Entities;

use Src\Providers\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\TransactionableId;

abstract class Transactionable
{
    public function __construct(
        public readonly TransactionableId $id,
        public readonly ProviderId $providerId,
    ) {
    }
}
