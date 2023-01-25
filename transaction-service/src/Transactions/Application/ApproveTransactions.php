<?php

namespace Src\Transactions\Application;

use DB;
use Src\Infrastructure\Events\Application\StoreEvent;
use Src\Infrastructure\Events\Entities\TransactionStored;
use Src\Infrastructure\Events\Exceptions\InvalidEventTypeException;
use Src\Infrastructure\Events\Exceptions\InvalidPayloadException;
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
        private readonly ApprovationTimedOut $timedOut,
        private readonly StoreEvent $storeEvent,
    ) {
    }

    /**
     * @throws InvalidTransaction
     * @throws InvalidPayloadException
     * @throws InvalidEventTypeException
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

            return;
        }

        $approved = $this->authorizer->handle($transaction);

        if (! $approved) {
            throw InvalidTransaction::notApproved($transaction);
        }

        DB::transaction(function () use ($transaction) {
            $this->storeEvent->handle(
                EventType::TRANSACTION_APPROVED,
                new TransactionApprovedPayload($transaction->id)
            );

            $this->applyTransaction->updateFromTransaction($transaction);
        });
    }
}
