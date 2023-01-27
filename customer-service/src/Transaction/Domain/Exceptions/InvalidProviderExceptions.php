<?php

namespace Src\Transaction\Domain\Exceptions;

use Exception;

class InvalidProviderExceptions extends Exception
{
    public static function providerDontExists(string $provider): self
    {
        return new self(sprintf('Provider <%s> doesn\'t exists.', $provider));
    }
}
