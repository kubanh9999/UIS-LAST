<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(Str::random(10)), 
            'discount_percent' => $this->faker->randomFloat(2, 0, 100),  
            'description' => $this->faker->sentence(), 
            'valid_form' => $this->faker->date(),  
            'valid_end' => $this->faker->date(),  
        ];
    }
}
