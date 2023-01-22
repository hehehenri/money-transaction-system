<?php

namespace Src\User\Domain\ValueObjects;

use Src\Shared\ValueObjects\StringValueObject;

class HashedPassword extends StringValueObject
{
    public function __construct(private readonly string $hashedPassword)
    {
        parent::__construct($this->hashedPassword);
    }
}
