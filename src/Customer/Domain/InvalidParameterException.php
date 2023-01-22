<?php

namespace Src\Customer\Domain;

use Exception;

class InvalidParameterException extends Exception
{
    public static function invalidCPF(string $cpf): self
    {
        return new self(sprintf('The given CPF<%s> is invalid.', $cpf));
    }
}
