<?php

namespace Src\Shared\Exceptions;

use Exception;

class DeserializeException extends Exception
{
    public static function cannotDeserializeFromValue(string $value): self
    {
        return new self(sprintf('Cannot deserialize from value<%s>.', $value));
    }
}
