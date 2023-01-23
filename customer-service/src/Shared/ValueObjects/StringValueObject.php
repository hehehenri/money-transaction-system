<?php

namespace Src\Shared\ValueObjects;

class StringValueObject
{
    public function __construct(protected readonly string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
