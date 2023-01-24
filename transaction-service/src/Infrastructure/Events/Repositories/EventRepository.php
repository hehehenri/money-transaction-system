<?php

namespace Src\Infrastructure\Events\Repositories;

use Src\Infrastructure\Events\Collections\EventCollection;
use Src\Infrastructure\Events\Entities\Event;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Events\ValueObjects\Payloads\Payload;

interface EventRepository
{
    public function create(Payload $dto): Event;

    public function getUnprocessed(EventType $type): EventCollection;
}
