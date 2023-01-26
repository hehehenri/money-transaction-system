<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Customer\Domain\Entities\Customer;
use Src\Infrastructure\Auth\JWTToken;
use Src\Infrastructure\Models\CustomerModel;
use Src\Infrastructure\Models\TokenModel;

/**
 * @extends Factory<TokenFactory>
 */
class TokenFactory extends Factory
{
    protected $model = TokenModel::class;

    /**
     * @return array<string, string>
     */
    public function definition(): array
    {
        return [
            'token' => JWTToken::encode(['email' => $this->faker->email]),
            'customer_id' => CustomerModel::factory(),
            'expires_at' => now()->addMonth(),
        ];
    }

    public function customer(Customer $customer): self
    {
        return $this->state([
            'token' => JWTToken::encode(['email' => (string) $customer->email]),
            'customer_id' => $customer->id,
        ]);
    }
}
