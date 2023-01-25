<?php

namespace Src\Infrastructure\Events\ValueObjects;

use Src\Infrastructure\Events\DTOs\EventDTO;
use Src\Infrastructure\Events\Entities\Event;
use Src\Infrastructure\Events\Entities\TransactionApproved;
use Src\Infrastructure\Events\Entities\TransactionStored;
use Src\Infrastructure\Events\Exceptions\InvalidPayloadException;
use Src\Infrastructure\Events\Handlers\EventHandler;
use Src\Infrastructure\Events\Handlers\TransactionApprovedHandler;
use Src\Infrastructure\Events\Handlers\TransactionStoredHandler;

enum EventType: string
{
    case TRANSACTION_STORED = 'transaction_stored';
    case TRANSACTION_APPROVED = 'transaction_approved';

    /** @throws InvalidPayloadException */
    public function intoEntity(EventDTO $dto): Event
    {
        return match ($this) {
            self::TRANSACTION_STORED => TransactionStored::fromDto($dto),
            self::TRANSACTION_APPROVED => TransactionApproved::fromDto($dto)
        };
    }

    public function handler(): EventHandler
    {
        /** @var EventHandler $handler */
        $handler = match ($this) {
            self::TRANSACTION_STORED => app(TransactionStoredHandler::class),
            self::TRANSACTION_APPROVED => app(TransactionApprovedHandler::class),
        };

        return $handler;
    }
}
