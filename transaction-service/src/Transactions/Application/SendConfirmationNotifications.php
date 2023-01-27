<?php

namespace Src\Transactions\Application;

use App\Jobs\DispatchConfirmationNotification;
use DB;
use Src\Infrastructure\Events\Entities\TransactionApproved;
use Src\Infrastructure\Events\Repositories\EventRepository;
use Src\Transactionables\Application\Exceptions\InvalidTransactionableException;
use Src\Transactionables\Application\GetTransactionable;
use Src\Transactions\Domain\ValueObjects\TransactionId;

class SendConfirmationNotifications
{
    public function __construct(
        private readonly GetTransactionable $getTransactionable,
        private readonly EventRepository $repository
    ) {
    }

    /**
     * @throws InvalidTransactionableException
     */
    public function handle(TransactionApproved $event): void
    {
        $transactionId = new TransactionId($event->payload->serialize());

        $receiver = $this->getTransactionable->receiverByTransaction($transactionId);

        /** @phpstan-ignore-next-line */
        DB::transaction(function () use ($receiver, $event) {
            DispatchConfirmationNotification::dispatch($receiver);

            $this->repository->markAsProcessed($event);
        });
    }
}
