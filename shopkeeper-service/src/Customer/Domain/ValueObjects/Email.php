<?php

namespace Src\Shopkeeper\Domain\ValueObjects;

use Src\Auth\Domain\Exceptions\ShopkeeperValidationException;
use Src\Shared\ValueObjects\StringValueObject;

class Email extends StringValueObject
{
    /** @throws ShopkeeperValidationException */
    public function __construct(string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw ShopkeeperValidationException::invalidEmail($value);
        }

        parent::__construct($value);
    }
}
