<?php

namespace Src\Infrastructure\Events\Handlers;

use Illuminate\Support\Facades\DB;
use Src\Shopkeeper\Application\GetShopkeeper;
use Src\Shopkeeper\Application\UpdateShopkeeperStatus;
use Src\Shopkeeper\Domain\Enums\Status;
use Src\Infrastructure\Events\Entities\ShopkeeperRegistered;
use Src\Infrastructure\Events\Repositories\EventRepository;
use Src\Infrastructure\Events\ValueObjects\Payloads\ShopkeeperRegisteredEventPayload;
use Src\Transaction\Application\RegisterShopkeeper;

class ShopkeeperRegisteredHandler extends EventHandler
{
    public function __construct(
        private readonly UpdateShopkeeperStatus $updateShopkeeperStatus,
        private readonly RegisterShopkeeper $registerShopkeeper,
        private readonly GetShopkeeper $getShopkeeper,
        EventRepository $eventRepository,
    ) {
        parent::__construct($eventRepository);
    }

    /** @param  array<ShopkeeperRegistered>  $events */
    public function handle(array $events): void
    {
        foreach ($events as $event) {
            /** @var ShopkeeperRegisteredEventPayload $payload */
            $payload = $event->payload;

            try {
                $Shopkeeper = $this->getShopkeeper->byId($payload->ShopkeeperId);
                $this->registerShopkeeper->intoTransactionsService($Shopkeeper);
            } catch (\Exception) {
                continue;
            }

            DB::transaction(function () use ($event, $Shopkeeper) {
                $this->markAsProcessed($event);
                $this->updateShopkeeperStatus->handle($Shopkeeper->id, Status::ACTIVE);
            });
        }
    }
}
