<?php

namespace Src\Infrastructure\Events\ValueObjects;

use Src\Infrastructure\Events\DTOs\EventDTO;
use Src\Infrastructure\Events\Entities\CustomerRegistered;
use Src\Infrastructure\Events\Entities\Event;
use Src\Infrastructure\Events\Exceptions\InvalidPayloadException;
use Src\Infrastructure\Events\Handlers\CustomerRegisteredHandler;
use Src\Infrastructure\Events\Handlers\EventHandler;

enum EventType: string
{
    case CUSTOMER_REGISTERED = 'customer_registered';

    /** @throws InvalidPayloadException */
    public function intoEntity(EventDTO $dto): Event
    {
        return match ($this) {
            self::CUSTOMER_REGISTERED => CustomerRegistered::fromDto($dto),
        };
    }

    public function handler(): EventHandler
    {
        /** @var EventHandler $handler */
        $handler = match ($this) {
            self::CUSTOMER_REGISTERED => app(CustomerRegisteredHandler::class),
        };

        return $handler;
    }
}
