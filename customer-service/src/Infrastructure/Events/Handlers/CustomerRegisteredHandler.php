<?php

namespace Src\Infrastructure\Events\Handlers;

use Illuminate\Support\Facades\DB;
use Src\Customer\Application\GetCustomer;
use Src\Customer\Application\UpdateCustomerStatus;
use Src\Customer\Domain\Enums\Status;
use Src\Infrastructure\Events\Entities\CustomerRegistered;
use Src\Infrastructure\Events\Repositories\EventRepository;
use Src\Infrastructure\Events\ValueObjects\Payloads\CustomerRegisteredEventPayload;
use Src\Transaction\Application\RegisterCustomer;

class CustomerRegisteredHandler extends EventHandler
{
    public function __construct(
        private readonly UpdateCustomerStatus $updateCustomerStatus,
        private readonly RegisterCustomer $registerCustomer,
        private readonly GetCustomer $getCustomer,
        EventRepository $eventRepository,
    ) {
        parent::__construct($eventRepository);
    }

    /** @param array<CustomerRegistered> $events */
    public function handle(array $events): void
    {
        foreach ($events as $event) {
            /** @var CustomerRegisteredEventPayload $payload */
            $payload = $event->payload;

            try {
                $customer = $this->getCustomer->byId($payload->customerId);
                $this->registerCustomer->handle($customer);
            } catch (\Exception) {
                continue;
            }

            DB::transaction(function () use ($event, $customer) {
                $this->markAsProcessed($event);
                $this->updateCustomerStatus->handle($customer->id, Status::ACTIVE);
            });
       }
    }
}
