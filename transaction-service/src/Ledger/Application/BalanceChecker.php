<?php

namespace Src\Ledger\Application;

use Src\Ledger\Application\Exceptions\InvalidLedger;
use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\Entities\Sender;
use Src\Transactionables\Domain\Exceptions\TransactionableNotFoundException;

class BalanceChecker
{
    public function __construct(private readonly GetLedger $getLedger)
    {
    }

    /**
     * @throws InvalidLedger
     * @throws TransactionableNotFoundException
     */
    public function canSendAmount(Sender $sender, Money $amount): bool
    {
        $ledger = $this->getLedger->byTransactionable($sender->providerId, $sender->provider);

        return $ledger->balance->value() >= $amount->value();
    }
}
