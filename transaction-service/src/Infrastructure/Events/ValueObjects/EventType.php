<?php

namespace Src\Infrastructure\Events\ValueObjects;

use Carbon\Carbon;
use Src\Infrastructure\Events\Entities\Event;
use Src\Infrastructure\Events\Entities\TransactionStored;
use Src\Infrastructure\Events\Exceptions\InvalidPayloadException;
use Src\Infrastructure\Events\ValueObjects\Payloads\TransactionStoredPayload;

enum EventType: string
{
    case TRANSACTION_STORED = 'transaction_stored';

    /** @throws InvalidPayloadException */
    public function intoEntity(
        EventId $id,
        string $payload,
        Carbon $processedAt,
        Carbon $createdAt,
    ): Event {
        return match($this) {
            self::TRANSACTION_STORED => new TransactionStored(
                $id,
                $this,
                TransactionStoredPayload::deserialize($payload),
                $processedAt,
                $createdAt
            )
        };
    }
}
