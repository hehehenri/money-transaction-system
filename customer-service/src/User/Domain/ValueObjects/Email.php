<?php

namespace Src\User\Domain\ValueObjects;

use Src\Shared\ValueObjects\StringValueObject;
use Src\User\Domain\Exceptions\UserValidationException;

class Email extends StringValueObject
{
    /** @throws UserValidationException */
    public function __construct(string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw UserValidationException::invalidEmail($value);
        }

        parent::__construct($value);
    }
}
