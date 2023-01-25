<?php

namespace Src\Transactionables\Application\Exceptions;

use Exception;
use Src\Transactionables\Domain\ValueObjects\TransactionableId;
use Src\Transactions\Domain\ValueObjects\TransactionId;

class InvalidTransactionableException extends Exception
{
    public static function transactionNotFound(TransactionId $id): self
    {
        return new self(sprintf('Transactionable don\'t have a transaction with ID<%s>.', $id));
    }

    public static function idNotFound(TransactionableId $id): self
    {
        return new self(sprintf('Transactionable with ID<%s> was not found.', $id));
    }
}
