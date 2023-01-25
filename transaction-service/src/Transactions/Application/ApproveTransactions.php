<?php

namespace Src\Transactions\Application;

use Src\Infrastructure\Events\Application\StoreEvent;
use Src\Infrastructure\Events\Entities\TransactionStored;
use Src\Infrastructure\Events\Exceptions\InvalidEventTypeException;
use Src\Infrastructure\Events\Exceptions\InvalidPayloadException;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Events\ValueObjects\Payloads\TransactionApprovedPayload;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactions\Application\Exceptions\InvalidTransaction;
use Src\Transactions\Domain\Repositories\TransactionRepository;
use Src\Transactions\Domain\UseCases\ApprovationTimedOut;
use Src\Transactions\Domain\ValueObjects\TransactionId;

class ApproveTransactions
{
    public function __construct(
        private readonly UpdateTransactionStatus $updateStatus,
        private readonly TransactionAuthorizer $authorizer,
        private readonly TransactionRepository $repository,
        private readonly ApprovationTimedOut $timedOut,
        private readonly StoreEvent $storeEvent,
    ) {
    }

    /**
     * @param  array<TransactionStored>  $events
     *
     * @throws InvalidTransaction
     * @throws InvalidPayloadException
     * @throws InvalidEventTypeException
     */
    public function handle(array $events): void
    {
        foreach ($events as $event) {
            $transacitonId = new TransactionId($event->payload->serialize());

            try {
                $transaction = $this->repository->findById($transacitonId);
            } catch (InvalidTransactionableException) {
                return;
            }

            if (! $transaction) {
                throw InvalidTransaction::notFound($transacitonId);
            }

            if (! $this->timedOut->check($transaction)) {
                $this->updateStatus->refusesTransaction($transaction);

                return;
            }

            $approved = $this->authorizer->handle($transaction);

            if (! $approved) {
                throw InvalidTransaction::notApproved($transaction);
            }

            $this->storeEvent->handle(EventType::TRANSACTION_APPROVED, new TransactionApprovedPayload($transacitonId));
        }
    }
}
