<?php

namespace Src\Infrastructure\Events\DTOs;

use Carbon\Carbon;
use Src\Infrastructure\Events\ValueObjects\EventType;

class EventDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $payload,
        public readonly EventType $type,
        public readonly ?Carbon $processedAt,
        public readonly Carbon $createdAt,
    ) {
    }
}
