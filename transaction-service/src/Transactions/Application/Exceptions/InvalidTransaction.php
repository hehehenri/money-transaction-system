<?php

namespace Src\Transactions\Application\Exceptions;

use Exception;
use Src\Transactionables\Domain\Entities\Sender;
use Src\Transactions\Domain\Entities\Transaction;
use Src\Transactions\Domain\ValueObjects\TransactionId;

class InvalidTransaction extends Exception
{
    public static function balanceIsNotEnough(Sender $sender): self
    {
        return new self(sprintf('Sender<%s> does not have enough balance to complete the transaction.', $sender->id));
    }

    public static function notApproved(Transaction $transaction): self
    {
        return new self(sprintf('Authorizer declined transaction with ID<%s>.', $transaction->id));
    }

    public static function notFound(TransactionId $id): self
    {
        return new self(sprintf('A transaction with ID<%s> was not found.', $id));
    }

    public static function timedOut(TransactionId $id): self
    {
        return new self(sprintf('Transaction with ID<%s> timed out.'), $id);
    }
}
