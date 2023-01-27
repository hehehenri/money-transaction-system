<?php

namespace Src\Auth\Application\Exceptions;

use Exception;
use Src\Shopkeeper\Domain\ValueObjects\Email;

class ShopkeeperValidationException extends Exception
{
    public static function ShopkeeperEmailNotFound(Email $email): self
    {
        return new self(sprintf('A Shopkeeper with the given email<%s> was not found.', (string) $email));
    }
}
