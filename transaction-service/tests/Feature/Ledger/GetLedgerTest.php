<?php

namespace Ledger;

use Illuminate\Support\Str;
use Src\Infrastructure\Models\LedgerModel;
use Src\Infrastructure\Models\TransactionableModel;
use Src\Transactionables\Domain\Enums\Provider;
use Tests\TestCase;

class GetLedgerTest extends TestCase
{
    public function testItShowsTransactionableLedger(): void
    {
        /** @var TransactionableModel $transactionableModel */
        $transactionableModel = TransactionableModel::factory()->create();
        LedgerModel::factory([
            'balance' => 150000,
            'transactionable_id' => $transactionableModel->id,
        ])->create();

        $transactionable = $transactionableModel->intoEntity();

        $this->getJson(route('ledger.show', [
            'provider' => $transactionable->provider->value,
            'provider_id' => (string) $transactionable->providerId
        ]))->assertOk();
    }

    /** @dataProvider invalidPayloads */
    public function testItReturnsValidationErrors(?string $providerId, ?string $provider): void
    {
        $this->getJson(route('ledger.show', [
            'provider' => $provider,
            'provider_id' => $providerId
        ]))->assertUnprocessable();
    }

    public function testTransactionableMustExist(): void
    {
        $this->getJson(route('ledger.show', [
            'provider' => Provider::CUSTOMERS->value,
            'provider_id' => Str::uuid()->toString(),
        ]))->assertNotFound();
    }

    /** @return array<string, array<string|null>> */
    public function invalidPayloads(): array
    {
        return [
            'null_values' => [null, null],
            'invalid_uuid' => ['invalid_uuid', Provider::CUSTOMERS->value],
            'invalid_provider' => [Str::uuid()->toString(), 'invalid_provider'],
        ];
    }
}
