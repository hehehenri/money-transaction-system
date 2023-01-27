<?php

namespace Src\Auth\Domain\Exceptions;

use Exception;
use Src\Shopkeeper\Domain\ValueObjects\Email;

class InvalidTokenException extends Exception
{
    public static function ShopkeeperNotFound(Email $email): self
    {
        return new self(sprintf('A Shopkeeper with ID<%s> was not found.', $email));
    }
}
