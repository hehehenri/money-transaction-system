<?php

namespace Src\Shared\ValueObjects;

class StringValueObject
{
    public function __construct(private readonly string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }
}
