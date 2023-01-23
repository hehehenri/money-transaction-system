<?php

namespace Src\User\Domain\Exceptions;

use Exception;
use Src\Shared\ValueObjects\Uuid;
use Src\User\Domain\Enums\UserType;

class InvalidTokenException extends Exception
{
    public static function tokenableNotFound(Uuid $tokenableId, UserType $tokenableType): self
    {
        return new self(sprintf('A %s with ID<%s> was not found.', $tokenableType->value, $tokenableId));
    }
}
