<?php

namespace Src\Infrastructure\Events\ValueObjects\Payloads;

use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;

class ShopkeeperRegisteredEventPayload implements EventPayload
{
    public function __construct(public readonly ShopkeeperId $ShopkeeperId)
    {
    }

    public function serialize(): string
    {
        return (string) $this->ShopkeeperId;
    }

    public static function deserialize(string $rawPayload): EventPayload
    {
        return new self(new ShopkeeperId($rawPayload));
    }
}
