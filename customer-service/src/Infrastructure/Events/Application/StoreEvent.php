<?php

namespace Src\Infrastructure\Events\Application;

use Src\Infrastructure\Events\Exceptions\InvalidEventTypeException;
use Src\Infrastructure\Events\Exceptions\InvalidPayloadException;
use Src\Infrastructure\Events\Repositories\EventRepository;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Events\ValueObjects\Payloads\EventPayload;

class StoreEvent
{
    public function __construct(private readonly EventRepository $repository)
    {
    }

    /**
     * @throws InvalidPayloadException
     * @throws InvalidEventTypeException
     */
    public function handle(EventType $type, EventPayload $payload): void
    {
        $this->repository->create($type, $payload);
    }
}
