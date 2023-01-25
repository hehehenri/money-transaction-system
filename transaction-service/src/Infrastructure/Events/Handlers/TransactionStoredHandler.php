<?php

namespace Src\Infrastructure\Events\Handlers;

use Exception;
use Src\Infrastructure\Events\Entities\TransactionStored;
use Src\Transactions\Application\ApproveTransactions;
use Src\Transactions\Application\Exceptions\InvalidTransaction;

class TransactionStoredHandler extends EventHandler
{
    /**
     * @param  array<TransactionStored>  $events
     */
    public function handle(array $events): void
    {
        foreach ($events as $event) {
            try {
                /** @var ApproveTransactions $aprover */
                $aprover = app(ApproveTransactions::class);

                $aprover->handle($event);
            } catch (InvalidTransaction|Exception) {
                return;
            }

            $this->markAsProcessed($event);
        }
    }
}
