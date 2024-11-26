<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shipment_date' => $this->faker->dateTime(),
            'status' => $this->faker->word,
            'tracking_number' => $this->faker->uuid,
            'carrier' => $this->faker->word,
        ];
    }
}
