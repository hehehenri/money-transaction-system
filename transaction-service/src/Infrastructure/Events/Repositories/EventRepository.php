<?php

namespace Src\Infrastructure\Events\Repositories;

use Src\Infrastructure\Events\Collections\UnprocessedEventsMap;
use Src\Infrastructure\Events\Entities\Event;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Events\ValueObjects\Payloads\Payload;

interface EventRepository
{
    public function create(EventType $type, Payload $payload): Event;

    public function getUnprocessed(): UnprocessedEventsMap;
}
