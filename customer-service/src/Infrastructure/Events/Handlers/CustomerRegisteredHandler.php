<?php

namespace Src\Infrastructure\Events\Handlers;

use Src\Infrastructure\Events\Entities\CustomerRegistered;

class CustomerRegisteredHandler extends EventHandler
{
    /** @param array<CustomerRegistered> $events */
    public function handle(array $events): void
    {
        foreach ($events as $event) {

        }
    }
}
