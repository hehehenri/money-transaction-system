<?php

namespace Src\Transactionables\Domain\Exceptions;

use Exception;
use Src\Transactionables\Domain\Enums\Provider;

class InvalidTransactionableException extends Exception
{
    public static function providerCannotBeSender(Provider $provider): self
    {
        return new self(
            sprintf('Transactionables from providers of type<%s> cannot send transactions.', $provider->value)
        );
    }
}
