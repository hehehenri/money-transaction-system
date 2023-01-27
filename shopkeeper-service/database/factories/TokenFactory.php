<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Infrastructure\Auth\JWTToken;
use Src\Infrastructure\Models\ShopkeeperModel;
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
            'Shopkeeper_id' => ShopkeeperModel::factory(),
            'expires_at' => now()->addMonth(),
        ];
    }

    public function Shopkeeper(Shopkeeper $Shopkeeper): self
    {
        return $this->state([
            'token' => JWTToken::encode(['email' => (string) $Shopkeeper->email]),
            'Shopkeeper_id' => $Shopkeeper->id,
        ]);
    }
}
