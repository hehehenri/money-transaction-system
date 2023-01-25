<?php

namespace Src\Ledger\Application\Exceptions;

use Exception;
use Src\Transactionables\Domain\ValueObjects\ProviderId;

class InvalidLedger extends Exception
{
    public static function transactionableIdNotFound(ProviderId $id): self
    {
        return new self(sprintf('A Ledger for the transactionable with the provider id<%s> was not found.', $id));
    }
}
