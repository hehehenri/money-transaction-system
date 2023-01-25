<?php

namespace Src\Ledger\Presentation\Exceptions;

use Exception;

class InvalidPayload extends Exception
{
    public static function providerDontExists(string $provider): self
    {
        return new self(sprintf('The given input<%s> is not a valid provider.', $provider));
    }
}
