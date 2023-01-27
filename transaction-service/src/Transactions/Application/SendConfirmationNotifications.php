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

        $transactionable = $this->getTransactionable->byTransaction($transactionId);

        /** @phpstan-ignore-next-line */
        DB::transaction(function () use ($transactionable, $event) {
            DispatchConfirmationNotification::dispatch($transactionable);

            $this->repository->markAsProcessed($event);
        });
    }
}
