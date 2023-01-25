<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Src\Infrastructure\Events\Repositories\EventRepository;
use Src\Infrastructure\Events\ValueObjects\EventType;

class HandleUnprocessedEvents extends Command
{
    protected $signature = 'events:handle';

    protected $description = 'Handle unprocessed events';

    public function handle(EventRepository $repository): int
    {
        $unprocessedEvents = $repository->getUnprocessed();

        foreach (EventType::cases() as $type) {
            $events = $unprocessedEvents->get($type->value);

            $type->handler()->handle($events);
        }

        return Command::SUCCESS;
    }
}
