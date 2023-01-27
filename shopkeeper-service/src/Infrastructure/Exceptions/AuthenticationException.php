<?php

namespace Src\Infrastructure\Exceptions;

use Exception;

class AuthenticationException extends Exception
{
    public static function invalidEmailOrPassword(): self
    {
        return new self('The given email or password is invalid.');
    }

    public static function cannotLoginUserType(): self
    {
        return new self('Cannot login this type of user.');
    }
}
