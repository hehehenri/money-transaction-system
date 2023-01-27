<?php

namespace Src\Infrastructure\Events\Handlers;

use Src\Infrastructure\Events\Entities\Event;

abstract class EventHandler
{
    /** @param  array<Event>  $events */
    abstract public function handle(array $events): void;
}
