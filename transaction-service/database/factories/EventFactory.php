<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Infrastructure\Events\ValueObjects\EventType;
use Src\Infrastructure\Models\EventModel;

/**
 * @extends Factory<EventModel>
 */
class EventFactory extends Factory
{
    protected $model = EventModel::class;

    /**
     * @return array<string, string>
     */
    public function definition(): array
    {
        /** @var EventType $type */
        $type = $this->faker->randomElement(EventType::cases());

        return [
            'type' => $type->value,
            'processed_at' => null,
            'created_at' => now()
        ];
    }

    public function processed(?Carbon $at = null): self
    {
        $at ??= now();

        return $this->state(
            /** @var array<string, string> $attributes */
            fn (array $attributes) => [
                    'processed_at' => $at
            ]
        );
    }
}
