<?php

namespace Src\Infrastructure\Clients\Exceptions;

use Exception;

class InvalidURIException extends Exception
{
    public static function wrongFormat(string $value): self
    {
        return new self(sprintf('The URI<%s> has an invalid format.', $value))
    }
}
