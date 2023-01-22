<?php

namespace Src\User\Domain\ValueObjects;

use Src\Shared\ValueObjects\StringValueObject;
use Src\User\Domain\Exceptions\InvalidParameterException;

class Email extends StringValueObject
{
    /** @throws InvalidParameterException */
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw InvalidParameterException::invalidEmail($value);
        }

        parent::__construct($value);
    }
}
