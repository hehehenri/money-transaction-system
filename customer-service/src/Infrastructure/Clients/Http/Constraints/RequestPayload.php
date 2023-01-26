<?php

namespace Src\Infrastructure\Clients\Http\Constraints;

interface RequestPayload
{
    public function jsonSerialize(): array;
}
