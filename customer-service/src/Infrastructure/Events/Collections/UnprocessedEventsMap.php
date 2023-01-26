<?php

namespace Src\Infrastructure\Events\Collections;

use Src\Infrastructure\Events\Entities\Event;
use Src\Shared\Collections\Map;

/**
 * @extends Map<Event>
 */
class UnprocessedEventsMap extends Map
{
    public function valueType(): string
    {
        return Event::class;
    }
}
