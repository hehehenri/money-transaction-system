<?php

namespace Src\Infrastructure\Events\Collections;

use Src\Infrastructure\Events\Entities\Event;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Shared\Collections\Map;

/**
 * @extends Map<string, Event>
 */
class UnprocessedEventsMap extends Map
{
    public function valueType(): string
    {
        return Event::class;
    }
}
