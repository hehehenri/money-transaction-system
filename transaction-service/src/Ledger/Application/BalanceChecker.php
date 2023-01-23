<?php

namespace Src\Ledger\Application;

use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\Entities\Sender;

class BalanceChecker
{
    public function canSendAmount(Sender $sender, Money $amount): bool
    {
        return true;
    }
}
