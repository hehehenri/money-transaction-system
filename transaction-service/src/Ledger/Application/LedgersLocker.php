<?php

namespace Src\Ledger\Application;

use Src\Transactionables\Domain\Entities\Receiver;
use Src\Transactionables\Domain\Entities\Sender;

class LedgersLocker
{
    public function __construct(private readonly TransactionableModel $model)
    {
    }

    public function lock(Sender $senderId, Receiver $receiverId): void
    {
    }

    public function unlock(): void
    {
    }
}
