<?php

namespace Src\Auth\Application\Exceptions;

use Exception;
use Src\Customer\Domain\ValueObjects\Email;

class CustomerValidationException extends Exception
{
    public static function customerEmailNotFound(Email $email): self
    {
        return new self(sprintf('A customer with the given email<%s> was not found.', (string) $email));
    }
}
