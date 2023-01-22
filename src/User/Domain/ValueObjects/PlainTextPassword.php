<?php

namespace Src\User\Domain\ValueObjects;

use Src\Shared\ValueObjects\StringValueObject;

class PlainTextPassword extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
