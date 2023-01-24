<?php

namespace Src\Infrastructure\Events\Entities;

use Carbon\Carbon;
use Src\Infrastructure\Events\ValueObjects\EventId;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Events\ValueObjects\Payloads\Payload;

abstract class Event
{
    public function __construct(
        public readonly EventId $id,
        public readonly EventType $type,
        public readonly Payload $payload,
        public readonly ?Carbon $processedAt,
        public readonly Carbon $createdAt
    ) {
    }
}
