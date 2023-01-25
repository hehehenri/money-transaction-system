<?php

namespace Src\Auth\Domain\Exceptions;

use Exception;
use Src\Customer\Domain\ValueObjects\CustomerId;

class InvalidTokenException extends Exception
{
    public static function customerNotFound(CustomerId $customerId): self
    {
        return new self(sprintf('A customer with ID<%s> was not found.', $customerId));
    }
}
