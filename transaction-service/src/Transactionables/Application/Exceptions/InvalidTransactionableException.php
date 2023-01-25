<?php

namespace Src\Transactionables\Application\Exceptions;

use Exception;
use Src\Transactions\Domain\ValueObjects\TransactionId;

class InvalidTransactionableException extends Exception
{
    public static function transactionNotFound(TransactionId $id): self
    {
        return new self(sprintf('Transactionable don\'t have a transaction with ID<%s>.', $id));
    }
}
