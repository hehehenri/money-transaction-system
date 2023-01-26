<?php

namespace Src\Infrastructure\Clients\Http\Exceptions;

use Exception;

class RequestException extends Exception
{
    public static function serviceIsUnavailable(): self
    {
        return new self('Cannot send request to unavailable service.');
    }
}
