<?php

namespace Src\Infrastructure\Factories;

use Avlima\PhpCpfCnpjGenerator\Generator as DocumentGenerator;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Src\Infrastructure\Models\CustomerModel;

/**
 * @extends Factory<CustomerModel>
 */
class CustomerFactory extends Factory
{
    protected $model = CustomerModel::class;

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
        ];
    }
}
