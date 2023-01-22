<?php

namespace Src\Infrastructure\Exceptions;

use Exception;

class AuthenticationException extends Exception
{
    public static function invalidEmailOrPassword(): self
    {
        return new self('The given email or password is invalid.');
    }
}
