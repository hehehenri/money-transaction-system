<?php

namespace Src\Shared\ValueObjects;

abstract class Stringable
{
    public function __construct(private readonly string $value)
    {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
