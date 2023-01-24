<?php

namespace Src\Infrastructure\Events\ValueObjects\Payloads;

use Src\Infrastructure\Events\Exceptions\InvalidPayloadException;

interface Payload
{
    public function serialize(): string;
    /** @throws InvalidPayloadException */
    public static function deserialize(string $rawPayload): self;
}
