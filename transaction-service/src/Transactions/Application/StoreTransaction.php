<?php

namespace Src\Transactions\Application;

use Illuminate\Support\Facades\DB;
use Src\Infrastructure\Clients\AuthorizerClient;
use Src\Ledger\Application\BalanceChecker;
use Src\Ledger\Application\LedgerLocker;
use Src\Transactionables\Application\GetTransactionable;
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
        private readonly AuthorizeTransaction $authorizeTransaction,
    ) {
    }

    /**
     * @throws InvalidTransactionableException
     * @throws TransactionableNotFoundException
     */
    public function handle(StoreTransactionViewModel $payload): Transaction
    {
        // Problems with this approach:
        // - If the transaction was commited, but not yet authorized and the
        //   system goes down, we cannot revert it, since it doesn't have a
        //   status or something, that we can check for, as an inconcistence
        //   indicator.

        // Future enhancements:
        // - As I said before, adding a status, and marking it after the whole
        //   operation completion should solve the problem.

        $transaction = $this->createTransaction($payload);

        if (!$this->authorizeTransaction($transaction)) {
            $this->
        }

        return $transaction;
    }

    /**
     * @throws InvalidTransactionableException
     * @throws TransactionableNotFoundException
     */
    private function createTransaction(StoreTransactionViewModel $payload): Transaction
    {
        $sender = $this->getTransactionable
            ->handle($payload->senderProviderId, $payload->senderProvider)
            ->asSender();
        $receiver = $this->getTransactionable
            ->handle($payload->receiverProviderId, $payload->receiverProvider)
            ->asReceiver();

        /** @var Transaction $transaction */
        $transaction = DB::transaction(function () use ($payload, $sender, $receiver) {
            $this->locker->lock($sender);

            $canSendAmount = $this->balanceChecker->canSendAmount($sender, $payload->amount);

            if (! $canSendAmount) {
                throw InvalidTransaction::balanceIsNotEnough($sender);
            }

            $dto = new StoreTransactionDTO($sender, $receiver, $payload->amount);

            return $this->transactionRepository->store($dto);
        });
    }

    private function authorizeTransaction(Transaction $transaction): bool
    {

    }
}
