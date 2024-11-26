<?php

namespace Database\Factories;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Tạo user giả
            'products_id' => \App\Models\Product::factory(), // Tạo product giả
            'quantity' => $this->faker->numberBetween(1, 10), // Số lượng từ 1 đến 10
        ];
    }
}
