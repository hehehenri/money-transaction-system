<?php

namespace Src\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Src\Infrastructure\Events\Collections\EventCollection;
use Src\Infrastructure\Events\Collections\UnprocessedEventsMap;
use Src\Infrastructure\Events\Entities\Event;
use Src\Infrastructure\Events\Exceptions\InvalidEventTypeException;
use Src\Infrastructure\Events\Exceptions\InvalidPayloadException;
use Src\Infrastructure\Events\Repositories\EventRepository;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Events\ValueObjects\Payloads\Payload;
use Src\Infrastructure\Models\EventModel;
use Src\Shared\Exceptions\InvalidItemException;

class EventEloquentRepository implements EventRepository
{
    public function __construct(private readonly EventModel $model)
    {
    }

    /**
     * @throws InvalidPayloadException
     * @throws InvalidEventTypeException
     */
    public function create(EventType $type, Payload $payload): Event
    {
        /** @var EventModel $event */
        $event = $this->model
            ->query()
            ->create([
                'type' => $type->value,
                'payload' => $payload->serialize(),
                'created_at' => now()
            ]);

        return $event->intoEntity();
    }

    /** @throws InvalidItemException */
    public function getUnprocessed(): UnprocessedEventsMap
    {
        /** @var Collection<EventModel> $transactions */
        $eventsModels = $this->model
            ->query()
            ->whereNull('processed_at')
            ->get();

        $events = $eventsModels->mapToGroups(function (EventModel $model) {
            $event = $model->intoEntity();

            return [$event->type->value => $event];
        });

        return new UnprocessedEventsMap($events->toArray());
    }
}
