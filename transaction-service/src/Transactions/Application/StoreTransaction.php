<?php

namespace Src\Transactions\Application;

use Illuminate\Support\Facades\DB;
use Src\Infrastructure\Events\Application\StoreEvent;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Events\ValueObjects\Payloads\TransactionStoredPayload;
use Src\Ledger\Application\BalanceChecker;
use Src\Ledger\Application\LedgerLocker;
use Src\Transactionables\Application\GetTransactionable;
use Src\Transactionables\Domain\Entities\Receiver;
use Src\Transactionables\Domain\Entities\Sender;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactionables\Domain\Exceptions\TransactionableNotFoundException;
use Src\Transactions\Application\Exceptions\InvalidTransaction;
use Src\Transactions\Domain\DTOs\StoreTransactionDTO;
use Src\Transactions\Domain\Entities\Transaction;
use Src\Transactions\Domain\Repositories\TransactionRepository;
use Src\Transactions\Presentation\Rest\ViewModels\StoreTransactionViewModel;

class StoreTransaction
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
        private readonly LedgerLocker $locker,
        private readonly BalanceChecker $balanceChecker,
        private readonly GetTransactionable $getTransactionable,
        private readonly StoreEvent $storeEvent,
    ) {
    }

    /**
     * @throws InvalidTransactionableException
     * @throws TransactionableNotFoundException
     * @throws InvalidTransaction
     */
    public function handle(StoreTransactionViewModel $payload): Transaction
    {
        $sender = $this->getTransactionable->byProvider($payload->senderProviderId, $payload->senderProvider)
            ->asSender();
        $receiver = $this->getTransactionable->byProvider($payload->receiverProviderId, $payload->receiverProvider)
            ->asReceiver();

        return $this->createTransaction($payload, $sender, $receiver);
    }

    /** @throws InvalidTransaction */
    private function createTransaction(
        StoreTransactionViewModel $payload,
        Sender $sender,
        Receiver $receiver
    ): Transaction {
        /** @var Transaction $transaction */
        $transaction = DB::transaction(function () use ($payload, $sender, $receiver) {
            $this->locker->lock($sender);
            $this->locker->lock($receiver);

            $canSendAmount = $this->balanceChecker->canSendAmount($sender, $payload->amount);

            if (! $canSendAmount) {
                throw InvalidTransaction::balanceIsNotEnough($sender);
            }

            $dto = new StoreTransactionDTO($sender, $receiver, $payload->amount);

            $transaction = $this->transactionRepository->store($dto);

            $this->storeEvent->store(
                EventType::TRANSACTION_STORED,
                new TransactionStoredPayload($transaction->id)
            );

            return $transaction;
        });

        return $transaction;
    }
}
