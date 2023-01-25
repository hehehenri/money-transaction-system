<?php

namespace Src\Infrastructure\Events\Handlers;

use Src\Infrastructure\Events\Entities\Event;

interface EventHandler
{
    /** @param  array<Event>  $events */
    public function handle(array $events): void;
}
