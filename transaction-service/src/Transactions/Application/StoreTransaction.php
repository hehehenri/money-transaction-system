<?php

namespace Src\Transactions\Application;

use Illuminate\Support\Facades\DB;
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
    ) {
    }

    /**
     * @throws InvalidTransactionableException
     * @throws TransactionableNotFoundException
     */
    public function handle(StoreTransactionViewModel $payload): Transaction
    {
        $sender = $this->getTransactionable->byProvider($payload->senderProviderId, $payload->senderProvider)
            ->asSender();
        $receiver = $this->getTransactionable->byProvider($payload->receiverProviderId, $payload->receiverProvider)
            ->asReceiver();

        return $this->createTransaction($payload, $sender, $receiver);
    }

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

            return $this->transactionRepository->store($dto);
        });

        return $transaction;
    }
}
