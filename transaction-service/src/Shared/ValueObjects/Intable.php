<?php

namespace Src\Shared\ValueObjects;

class Intable
{
    public function __construct(protected readonly int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }
}
