<?php

namespace Src\Customer\Domain\ValueObjects;

use Src\Auth\Domain\Exceptions\CustomerValidationException;
use Src\Shared\ValueObjects\StringValueObject;

class Email extends StringValueObject
{
    /** @throws CustomerValidationException */
    public function __construct(string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw CustomerValidationException::invalidEmail($value);
        }

        parent::__construct($value);
    }
}
