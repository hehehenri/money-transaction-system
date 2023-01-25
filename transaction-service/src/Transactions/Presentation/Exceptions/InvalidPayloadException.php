<?php

namespace Src\Transactions\Presentation\Exceptions;

use Exception;

class InvalidPayloadException extends Exception
{
    public static function invalidProvider(string $input): self
    {
        return new self(sprintf('The given input<%s> is not a valid provider.', $input));
    }
}
