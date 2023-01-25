<?php

namespace Src\Infrastructure\Events\Handlers;

use Src\Infrastructure\Events\Entities\TransactionStored;
use Src\Transactions\Application\ApproveTransactions;
use Src\Transactions\Application\Exceptions\InvalidTransaction;

class TransactionStoredHandler implements EventHandler
{
    /**
     * @param  array<TransactionStored>  $events
     */
    public function handle(array $events): void
    {
        try {
            /** @var ApproveTransactions $aprover */
            $aprover = app(ApproveTransactions::class);

            $aprover->handle($events);
        } catch (InvalidTransaction|\Exception) {
            return;
        }
    }
}
