<?php

namespace Events\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Src\Infrastructure\Events\Repositories\EventRepository;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Events\ValueObjects\Payloads\TransactionStoredPayload;
use Src\Infrastructure\Models\EventModel;
use Src\Transactions\Domain\ValueObjects\TransactionId;
use Tests\TestCase;

/** @group test */
class EventRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testItGetsAllTheUnprocessableEvents(): void
    {
        $type = EventType::TRANSACTION_STORED;
        $payload = new TransactionStoredPayload(new TransactionId(Str::uuid()->toString()));

        $events = EventModel::factory([
                'type' => $type->value,
                'payload' => $payload->serialize(),
            ])
            ->count(2)
            ->create();

        $repository = app(EventRepository::class);

        $this->assertEquals(2, count($repository->getUnprocessed()->get($type->value)));
    }
}
