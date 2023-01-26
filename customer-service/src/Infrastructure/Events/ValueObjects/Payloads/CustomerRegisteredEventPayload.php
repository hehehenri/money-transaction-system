<?php

namespace Src\Infrastructure\Events\ValueObjects\Payloads;

use Src\Customer\Domain\ValueObjects\CustomerId;

class CustomerRegisteredEventPayload implements EventPayload
{
    public function __construct(private readonly CustomerId $customerId)
    {
    }

    public function serialize(): string
    {
        return (string) $this->customerId;
    }

    public static function deserialize(string $rawPayload): EventPayload
    {
        return new self(new CustomerId($rawPayload));
    }
}
