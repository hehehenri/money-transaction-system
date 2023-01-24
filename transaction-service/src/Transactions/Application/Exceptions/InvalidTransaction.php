<?php

namespace Src\Transactions\Application\Exceptions;

use Exception;
use Src\Transactionables\Domain\Entities\Sender;
use Src\Transactions\Domain\Entities\Transaction;

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
}
