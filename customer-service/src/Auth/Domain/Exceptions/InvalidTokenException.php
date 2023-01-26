<?php

namespace Src\Auth\Domain\Exceptions;

use Exception;
use Src\Customer\Domain\ValueObjects\Email;

class InvalidTokenException extends Exception
{
    public static function customerNotFound(Email $email): self
    {
        return new self(sprintf('A customer with ID<%s> was not found.', $email));
    }
}
