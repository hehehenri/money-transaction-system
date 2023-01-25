<?php

namespace Tests\Feature\Transactions;

use Illuminate\Support\Str;
use Src\Infrastructure\Models\TransactionableModel;
use Src\Transactionables\Domain\Enums\Provider;
use Tests\TestCase;

class RegisterTransactionableTest extends TestCase
{
    /**
     * @param  string  $providerId
     * @param  Provider  $provider
     * @return void
     *
     * @dataProvider validPayload
     */
    public function testItRegistersATransactionable(string $providerId, Provider $provider): void
    {
        $response = $this->postJson(route('transactionable.register'), [
            'provider_id' => $providerId,
            'provider' => $provider->value,
        ]);

        $response->assertCreated();

        $transactionable = TransactionableModel::query()->where('provider_id', $providerId)->first();

        $this->assertEquals($transactionable->intoEntity()->provider, $provider);
    }

    /**
     * @param  string  $providerId
     * @param  string  $provider
     * @return void
     *
     * @dataProvider invalidPayload
     */
    public function testItReturnsValidationErrors(string $providerId, string $provider): void
    {
        $response = $this->postJson(route('transactionable.register'), [
            'provider_id' => $providerId,
            'provider' => $provider,
        ]);
        $response->assertUnprocessable();
    }

    /** @return array<string, array<string, Provider>> */
    public function validPayload(): array
    {
        return [
            'customer' => [Str::uuid()->toString(), Provider::CUSTOMERS],
            'shopkeeper' => [Str::uuid()->toString(), Provider::SHOPKEEPERS],
        ];
    }

    /** @return array<string, array<string, string> */
    public function invalidPayload(): array
    {
        return [
            'invalid_uuid' => ['invalid_uuid', Provider::CUSTOMERS->value],
            'invalid_provider' => [Str::uuid()->toString(), 'wrong_provider'],
        ];
    }
}
