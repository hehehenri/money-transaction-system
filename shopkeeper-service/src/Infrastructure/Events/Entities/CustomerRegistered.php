<?php

namespace Src\Infrastructure\Events\Entities;

use Src\Infrastructure\Events\DTOs\EventDTO;
use Src\Infrastructure\Events\Exceptions\InvalidPayloadException;
use Src\Infrastructure\Events\ValueObjects\EventId;
use Src\Infrastructure\Events\ValueObjects\Payloads\ShopkeeperRegisteredEventPayload;

class ShopkeeperRegistered extends Event
{
    /** @throws InvalidPayloadException */
    public static function fromDto(EventDTO $fromDatabase): Event
    {
        return new self(
            new EventId($fromDatabase->id),
            $fromDatabase->type,
            ShopkeeperRegisteredEventPayload::deserialize($fromDatabase->payload),
            $fromDatabase->processedAt,
            $fromDatabase->createdAt
        );
    }
}
