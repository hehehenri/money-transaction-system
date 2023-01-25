<?php

namespace Events\Handlers;

use Src\Infrastructure\Events\Repositories\EventRepository;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Models\EventModel;
use Src\Infrastructure\Models\TransactionModel;
use Tests\TestCase;
use Tests\Traits\MocksNotifier;

class TransactionStoredHandlerTest extends TestCase
{
    use MocksNotifier;

    public function testItDispatchesNotificationAndMarksTheEventAsProcessed(): void
    {
        $this->notifyWithSuccess();

        $transactions = TransactionModel::factory()
            ->pending()
            ->count(4)
            ->create();

        $transactions->each(function (TransactionModel $transaction) {
            /** @var EventModel $event */
            EventModel::factory([
                'payload' => $transaction->id,
                'type' => EventType::TRANSACTION_APPROVED->value,
            ])->create();
        });

        $events = app(EventRepository::class)
            ->getUnprocessed()
            ->get(EventType::TRANSACTION_APPROVED->value);

        EventType::TRANSACTION_APPROVED->handler()->handle($events);

        foreach ($events as $event) {
            /** @var EventModel $event */
            $event = EventModel::query()->find($event->id);

            $this->assertNotNull($event->processed_at);
        }
    }
}
