<?php

namespace Src\User\Domain\Exceptions;

use Exception;

class InvalidParametersException extends Exception
{
    /** @throws InvalidParametersException */
    public static function fullNameLengthIsOutOfRange(string $value) {
        throw new self(sprintf('The given full name<%s> is too long or too short.', $value));
    }

    public static function fullNameContainsInvalidCharacters(string $value)
    {
        throw new self(sprintf('The given full name<%s> can only contain letters, spaces, hyphens, and apostrophes.', $value));
    }
}
