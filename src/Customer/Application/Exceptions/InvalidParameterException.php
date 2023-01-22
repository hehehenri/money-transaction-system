<?php

namespace Src\Customer\Application\Exceptions;

use Exception;
use Src\User\Domain\ValueObjects\Email;

class InvalidParameterException extends Exception
{
    public static function customerEmailNotFound(Email $email): self
    {
        return new self(sprintf('A customer with the given email<%s> was not found.', (string) $email));
    }
}
