<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Infrastructure\Models\LedgerModel;
use Src\Infrastructure\Models\TransactionableModel;

/**
 * @extends Factory<LedgerModel>
 */
class LedgerFactory extends Factory
{
    protected $model = LedgerModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, string>
     */
    public function definition(): array
    {
        return [
            'transactionable_id' => TransactionableModel::factory(),
            'amount' => $this->faker->numberBetween(100, 100000),
        ];
    }
}
