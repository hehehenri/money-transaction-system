<?php

namespace Src\Infrastructure\Clients\Http\Exceptions;

use Exception;

class RequestException extends Exception
{
    public static function serviceIsUnavailable(): self
    {
        return new self('Cannot send request to unavailable service.');
    }

    public static function invalidFormat(Exception $e): self
    {
        return new self(sprintf('Could not build the request from the given paramaters. Context: <%s>', $e->getMessage()));
    }
}
