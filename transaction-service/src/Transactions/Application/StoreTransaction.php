<?php

namespace Src\Transactions\Application;

use Illuminate\Support\Facades\DB;
use Src\Ledger\Application\BalanceChecker;
use Src\Ledger\Application\LedgerLocker;
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
    ) {
    }

    public function handle(StoreTransactionViewModel $payload): Transaction
    {
        return $this->createTransaction($payload);
    }

    private function createTransaction(StoreTransactionViewModel $payload): Transaction
    {
        /** @var Transaction $transaction */
        $transaction = DB::transaction(function () use ($payload) {
            $this->locker->lockSender($payload->sender);

            $canSendAmount = $this->balanceChecker->canSendAmount($payload->sender, $payload->amount);

            if (! $canSendAmount) {
                throw InvalidTransaction::balanceIsNotEnough($payload->sender);
            }

            $dto = new StoreTransactionDTO(
                $payload->sender,
                $payload->receiver,
                $payload->amount,
            );

            return $this->transactionRepository->store($dto);
        });

        return $transaction;
    }
}
