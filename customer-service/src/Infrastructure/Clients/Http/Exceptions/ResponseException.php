<?php

namespace Src\Infrastructure\Clients\Http\Exceptions;

use Exception;

class ResponseException extends Exception
{
    public static function internalServerError(): self
    {
        return new self('External service returned an internal server error.');
    }

    public static function invalidStatusCode(int $statusCode): self
    {
        return new self(
            sprintf('External service returned an unexpected status code<%s>', $statusCode)
        );
    }
}
