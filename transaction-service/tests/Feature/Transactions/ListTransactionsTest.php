<?php

namespace Tests\Feature\Transactions;

use Illuminate\Database\Eloquent\Collection;
use Src\Infrastructure\Models\TransactionableModel;
use Src\Infrastructure\Models\TransactionModel;
use Tests\TestCase;

class ListTransactionsTest extends TestCase
{
    public function testItListsTransactions(): void
    {
        /** @var TransactionableModel $transactionableModel */
        $transactionableModel = TransactionableModel::factory()->create();
        $transactionable = $transactionableModel->intoEntity();

        /** @var Collection<TransactionModel> $transactions */
        $transactions = TransactionModel::factory(['sender_id' => $transactionable->id])->count(2)->create();

        $response = $this->getJson(route('transaction.list', [
            'provider_id' => (string) $transactionable->providerId,
            'provider' => $transactionable->provider->value,
            'per_page' => 2,
            'page' => 1,
        ]));

        $response->assertOk()
            ->assertSee(['sender_id' => $transactionable->id]);
    }
}
