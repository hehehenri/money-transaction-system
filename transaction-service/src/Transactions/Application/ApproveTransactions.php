<?php

namespace Src\Transactions\Application;

use Illuminate\Support\Facades\DB;
use Src\Infrastructure\Events\Application\StoreEvent;
use Src\Infrastructure\Events\Entities\TransactionStored;
use Src\Infrastructure\Events\Repositories\EventRepository;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Events\ValueObjects\Payloads\TransactionApprovedPayload;
use Src\Ledger\Application\ApplyTransaction;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactions\Application\Exceptions\InvalidTransaction;
use Src\Transactions\Domain\Repositories\TransactionRepository;
use Src\Transactions\Domain\UseCases\ApprovationTimedOut;
use Src\Transactions\Domain\ValueObjects\TransactionId;

class ApproveTransactions
{
    public function __construct(
        private readonly UpdateTransactionStatus $updateStatus,
        private readonly ApplyTransaction $applyTransaction,
        private readonly TransactionAuthorizer $authorizer,
        private readonly TransactionRepository $repository,
        private readonly EventRepository $eventRepository,
        private readonly ApprovationTimedOut $timedOut,
        private readonly StoreEvent $storeEvent,
    ) {
    }

    /**
     * @throws InvalidTransaction
     */
    public function handle(TransactionStored $event): void
    {
        $transactionId = new TransactionId($event->payload->serialize());

        try {
            $transaction = $this->repository->findById($transactionId);
        } catch (InvalidTransactionableException) {
            return;
        }

        if (! $transaction) {
            throw InvalidTransaction::notFound($transactionId);
        }

        if (! $this->timedOut->check($transaction)) {
            $this->updateStatus->refusesTransaction($transaction);
            $this->eventRepository->markAsProcessed($event);

            return;
        }

        $approved = $this->authorizer->handle($transaction);

        if (! $approved) {
            $this->eventRepository->markAsProcessed($event);

            throw InvalidTransaction::notApproved($transaction);
        }

        DB::transaction(function () use ($transaction, $event) {
            $this->storeEvent->store(
                EventType::TRANSACTION_APPROVED,
                new TransactionApprovedPayload($transaction->id)
            );

            $this->applyTransaction->updateFromTransaction($transaction);

            $this->eventRepository->markAsProcessed($event);
        });
    }
}
