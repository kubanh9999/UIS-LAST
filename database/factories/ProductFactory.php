<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'category_id' => \App\Models\Category::factory(), 
            'product_type_id' => \App\Models\ProductType::factory(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'discount' => $this->faker->randomFloat(2, 0, 0.5), 
            'stock' => $this->faker->numberBetween(1, 100), 
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(640, 480, 'product', true),
        ];
    }
}
