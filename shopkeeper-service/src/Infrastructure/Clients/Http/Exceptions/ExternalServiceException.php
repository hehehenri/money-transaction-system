<?php

namespace Src\Infrastructure\Clients\Http\Exceptions;

class ExternalServiceException extends \Exception
{
    public static function serviceUnavailable(): self
    {
        return new self('The external service is down. Try again later.');
    }
}
