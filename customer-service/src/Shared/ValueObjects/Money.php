<?php

namespace Src\Shared\ValueObjects;

class Money
{
    public function __construct(private readonly int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }
}
