<?php

namespace Src\User\Domain\Exceptions;

use Exception;

class InvalidUserType extends Exception
{
    public static function notImplemented(string $type): self
    {
        return new self(sprintf('The given type<%s> was not implemented yet.', $type));
    }
}
