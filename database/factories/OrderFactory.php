<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'status' => $this->faker->word,
            'payment_method' => $this->faker->word,
            'user_id' => \App\Models\User::factory(),
            'total_amount' => $this->faker->randomFloat(2, 10, 1000),
            'order_date' => $this->faker->dateTime(),
            'discounts_id' => \App\Models\Discount::factory(), // Hoặc bạn có thể tạo factory cho discounts
        ];
    }
}
