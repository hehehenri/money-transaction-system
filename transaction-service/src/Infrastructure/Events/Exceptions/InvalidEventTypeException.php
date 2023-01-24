<?php

namespace Src\Infrastructure\Events\Exceptions;

use Exception;

class InvalidEventTypeException extends Exception
{
    public static function cannotDeserializeFromType(string $type): self
    {
        return new self(sprintf('Failed to deserialize exception from type<%s>.', $type));
    }
}
