<?php

namespace Src\Shared\Exceptions;

use Exception;

class InvalidItemException extends Exception
{
    public static function invalidType(string $expected, string $parameter): self
    {
        return new self(sprintf(
            'The collection expected a parameter of type<%s>, but <%s> was given.',
            $expected,
            $parameter
        ));
    }
}
