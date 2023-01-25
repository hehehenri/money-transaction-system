<?php

namespace Src\Infrastructure\Events\Handlers;

use Exception;
use Src\Infrastructure\Events\Entities\TransactionApproved;
use Src\Transactions\Application\SendConfirmationNotifications;

class TransactionApprovedHandler implements EventHandler
{
    /**
     * @param  array<TransactionApproved>  $events
     *
     * @throws Exception
     */
    public function handle(array $events): void
    {
        /** @var SendConfirmationNotifications $sender */
        $sender = app(SendConfirmationNotifications::class);

        $sender->handle($events);
    }
}
