<?php

namespace Src\Infrastructure\Events\Handlers;

use Src\Infrastructure\Events\Entities\Event;
use Src\Infrastructure\Events\Repositories\EventRepository;

abstract class EventHandler
{
    public function __construct(private readonly EventRepository $repository)
    {
    }

    /** @param  array<Event>  $events */
    abstract public function handle(array $events): void;

    public function markAsProcessed(Event $event): void
    {
        $this->repository->markAsProcessed($event);
    }
}
