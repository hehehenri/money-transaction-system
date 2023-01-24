<?php

namespace Src\Infrastructure\Clients\Exceptions;

use Exception;
use Src\Infrastructure\Clients\ValueObjects\URI;

class RequestException extends Exception
{
    public static function requestFailed(URI $uri): self
    {
        return new self(sprintf('Failed to send request to URI<%s>', $uri));
    }

    public static function serviceIsUnavailable(): self
    {
        return new self('Cannot send request to unavailable service.');
    }
}
