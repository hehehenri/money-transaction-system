<?php

namespace Src\Infrastructure\Clients\Http\ValueObjects;

interface Body
{
    public function jsonSerialize(): string;
}
