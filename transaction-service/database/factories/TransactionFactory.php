<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Infrastructure\Models\TransactionableModel;
use Src\Infrastructure\Models\TransactionModel;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactions\Domain\Enums\TransactionStatus;

/**
 * @extends Factory<TransactionModel>
 */
class TransactionFactory extends Factory
{
    protected $model = TransactionModel::class;

    /** @return array<string, string> */
    public function definition(): array
    {
        $status = $this->faker->randomElement(TransactionStatus::cases());

        return [
            'sender_id' => TransactionableModel::factory(['provider' => Provider::CUSTOMERS->value]),
            'receiver_id' => TransactionableModel::factory(),
            'amount' => $this->faker->numberBetween(1000, 10000),
            'status' => $status->value,
        ];
    }
}
