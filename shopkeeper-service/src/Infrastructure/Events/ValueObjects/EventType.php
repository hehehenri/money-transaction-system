<?php

namespace Src\Infrastructure\Events\ValueObjects;

use Src\Infrastructure\Events\DTOs\EventDTO;
use Src\Infrastructure\Events\Entities\ShopkeeperRegistered;
use Src\Infrastructure\Events\Entities\Event;
use Src\Infrastructure\Events\Exceptions\InvalidPayloadException;
use Src\Infrastructure\Events\Handlers\ShopkeeperRegisteredHandler;
use Src\Infrastructure\Events\Handlers\EventHandler;

enum EventType: string
{
    case Shopkeeper_REGISTERED = 'Shopkeeper_registered';

    /** @throws InvalidPayloadException */
    public function intoEntity(EventDTO $dto): Event
    {
        return match ($this) {
            self::Shopkeeper_REGISTERED => ShopkeeperRegistered::fromDto($dto),
        };
    }

    public function handler(): EventHandler
    {
        /** @var EventHandler $handler */
        $handler = match ($this) {
            self::Shopkeeper_REGISTERED => app(ShopkeeperRegisteredHandler::class),
        };

        return $handler;
    }
}
