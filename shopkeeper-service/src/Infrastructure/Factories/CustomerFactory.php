<?php

namespace Src\Infrastructure\Factories;

use Avlima\PhpCpfCnpjGenerator\Generator as DocumentGenerator;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Src\Shopkeeper\Domain\Enums\Status;
use Src\Infrastructure\Models\ShopkeeperModel;

/**
 * @extends Factory<ShopkeeperModel>
 */
class ShopkeeperFactory extends Factory
{
    protected $model = ShopkeeperModel::class;

    /**
     * @return array<string, string>
     *
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'full_name' => sprintf('%s %s', $this->faker->lastName, $this->faker->lastName),
            'email' => $this->faker->email,
            'document' => DocumentGenerator::cpf(),
            'password' => Hash::make($this->faker->password),
            'status' => Status::PENDING->value,
        ];
    }
}
