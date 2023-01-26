<?php

namespace Src\Infrastructure\Clients\Http\Exceptions;

use Exception;
use Src\Infrastructure\Clients\Http\ValueObjects\URI;

class RequestException extends Exception
{
    public static function serviceIsUnavailable(): self
    {
        return new self('Cannot send request to unavailable service.');
    }
}
