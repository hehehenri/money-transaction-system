<?php

namespace Src\Infrastructure\Events\Entities;

use Carbon\Carbon;
use Src\Infrastructure\Events\ValueObjects\EventId;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Events\ValueObjects\Payloads\Payload;

class TransactionStored extends Event
{
    public function __construct(EventId $id, EventType $type, Payload $payload, ?Carbon $processedAt, Carbon $createdAt)
    {
        parent::__construct($id, $type, $payload, $processedAt, $createdAt);
    }
}
