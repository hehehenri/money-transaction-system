<?php

namespace Src\Infrastructure\Events\Collections;

use Src\Infrastructure\Events\Entities\Event;
use Src\Shared\Collections\Collection;

/**
 * @extends Collection<Event>
 */
final class EventCollection extends Collection
{
    public function type(): string
    {
        return Event::class;
    }
}
