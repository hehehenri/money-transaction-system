<?php

namespace Src\Ledger\Application;

use Src\Transactionables\Domain\Entities\Sender;

class LedgerLocker
{
    public function lockSender(Sender $sender): void
    {
    }
}
