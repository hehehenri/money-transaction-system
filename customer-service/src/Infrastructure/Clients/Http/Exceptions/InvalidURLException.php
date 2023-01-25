<?php

namespace Src\Infrastructure\Clients\Http\Exceptions;

use Exception;

class InvalidURLException extends Exception
{
    public static function wrongFormat(string $value): self
    {
        return new self(sprintf('The URI<%s> has an invalid format.', $value));
    }
}
