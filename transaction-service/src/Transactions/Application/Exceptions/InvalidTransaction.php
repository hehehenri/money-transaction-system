<?php

namespace Src\Transactions\Application\Exceptions;

use Exception;
use Src\Transactionables\Domain\Entities\Sender;

class InvalidTransaction extends Exception
{
    public static function balanceIsNotEnough(Sender $sender): self
    {
        return new self(sprintf('Sender<%s> does not have enough balance to complete the transaction.', $sender->id));
    }
}
