<?php

namespace Src\Shared\Exceptions;

use Exception;

class InvalidParameterException extends Exception
{
    public static function invalidEmail(string $value): self
    {
        return new self(sprintf('The given email<%s> is invalid.', $value));
    }
}
