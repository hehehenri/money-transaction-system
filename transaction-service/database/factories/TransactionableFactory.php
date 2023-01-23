<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\Infrastructure\Models\TransactionableModel;
use Src\Transactionables\Domain\Enums\Provider;

/**
 * @extends Factory<TransactionableModel>
 */
class TransactionableFactory extends Factory
{
    protected $model = TransactionableModel::class;

    /** @return array<string, string> */
    public function definition(): array
    {
        /** @var Provider $provider */
        $provider = $this->faker->randomElement(Provider::cases());

        return [
            'provider_id' => $this->faker->uuid,
            'provider' => $provider->value,
        ];
    }
}
