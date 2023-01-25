<?php

namespace Src\Infrastructure\Events\Handlers;

use Src\Infrastructure\Events\Entities\TransactionStored;

class TransactionStoredHandler implements EventHandler
{
    /** @param array<TransactionStored> $events */
    public function handle(array $events): void
    {
    }
}
