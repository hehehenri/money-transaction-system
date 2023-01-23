<?php

namespace Tests\Feature\Transactionables;

use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Src\Infrastructure\Models\TransactionableModel;
use Src\Transactionables\Domain\Enums\Provider;
use Tests\TestCase;

class RegisterTransactionableTest extends TestCase
{
    /** @dataProvider validPayload */
    public function testItRegisterTransactionable(string $provider, string $uuid): void
    {
        $response = $this->request([
            'provider_id' => $uuid,
            'provider' => $provider
        ]);

        $response->assertCreated()
            ->assertSee([$provider, $uuid]);

        $transactionable = TransactionableModel::where('provider_id', $uuid)->first();

        $this->assertEquals($transactionable->provider, $provider);
    }

    /** @return array<string, <array<string, string>> */
    public function validPayload(): array
    {
        $payloads = [];

        foreach(Provider::cases() as $case) {
            $payloads[$case->value] = [$case->value, Str::uuid()->toString()];
        }

        return $payloads;
    }

    private function request(array $payload): TestResponse
    {
        return $this->postJson(route('transactionable.register'), $payload);
        $this->assertEquals($transactionable->provider_id, $uuid);
    }
}
