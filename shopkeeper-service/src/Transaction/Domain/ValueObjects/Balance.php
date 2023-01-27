<?php

namespace Src\Transaction\Domain\ValueObjects;

use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Shared\ValueObjects\Money;

final class Balance
{
    public function __construct(
        public readonly Money $amount,
        public readonly Shopkeeper $Shopkeeper
    ) {
    }
}
