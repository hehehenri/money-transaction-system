<?php

namespace Src\Infrastructure\Events\Exceptions;

use Exception;

class InvalidPayloadException extends Exception
{
    public static function cannotDeserializeFrom(string $rawPayload): self
    {
        return new self(sprintf('Cannot deserialize payload from<%s>', $rawPayload));
    }
}
