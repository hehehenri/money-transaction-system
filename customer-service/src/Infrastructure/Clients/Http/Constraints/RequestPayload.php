<?php

namespace Src\Infrastructure\Clients\Http\Constraints;

interface RequestPayload
{
    /** @return array<string, string> */
    public function jsonSerialize(): array;
}
