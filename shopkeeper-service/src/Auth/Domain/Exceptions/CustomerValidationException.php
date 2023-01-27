<?php

namespace Src\Auth\Domain\Exceptions;

use Exception;

class ShopkeeperValidationException extends Exception
{
    public static function fullNameLengthIsOutOfRange(string $value): self
    {
        return new self(sprintf('The given full name<%s> is too long or too short.', $value));
    }

    public static function fullNameContainsInvalidCharacters(string $value): self
    {
        return new self(sprintf('The given full name<%s> can only contain letters, spaces, hyphens, and apostrophes.', $value));
    }

    public static function invalidEmail(string $value): self
    {
        return new self(sprintf('The given email<%s> is invalid.', $value));
    }
}
