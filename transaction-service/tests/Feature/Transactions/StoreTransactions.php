<?php

namespace Tests\Feature\Transactions;

use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class StoreTransactions extends TestCase
{
    public function testCanStoreTransactions(): void
    {
        $response = $this->route([
            '',
        ]);
    }

    /** @param  array<string, string>  $payload */
    private function route(array $payload): TestResponse
    {
        return $this->postJson(route('transactions.store-transacitons'), $payload);
    }
}
