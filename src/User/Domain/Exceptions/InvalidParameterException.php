<?php

namespace Src\User\Domain\Exceptions;

use Exception;

class InvalidParameterException extends Exception
{
    /** @throws InvalidParameterException */
    public static function fullNameLengthIsOutOfRange(string $value) {
        throw new self(sprintf('The given full name<%s> is too long or too short.', $value));
    }

    /** @throws InvalidParameterException */
    public static function fullNameContainsInvalidCharacters(string $value)
    {
        throw new self(sprintf('The given full name<%s> can only contain letters, spaces, hyphens, and apostrophes.', $value));
    }

    /** @throws InvalidParameterException */
    public static function invalidEmail(string $value)
    {
        throw new self(sprintf('The given email<%s> is invalid.', $value));
    }
}
