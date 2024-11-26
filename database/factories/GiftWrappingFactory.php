<?php

namespace Database\Factories;

use App\Models\GiftWrapping;
use Illuminate\Database\Eloquent\Factories\Factory;

class GiftWrappingFactory extends Factory
{
    protected $model = GiftWrapping::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Tạo user giả
            'price' => $this->faker->randomFloat(2, 5, 50), // Giá ngẫu nhiên từ 5 đến 50
            'tag' => $this->faker->word, // Tag ngẫu nhiên
        ];
    }
}
