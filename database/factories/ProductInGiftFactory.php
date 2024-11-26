<?php

namespace Database\Factories;

use App\Models\ProductInGift;
use App\Models\Product;
use App\Models\GiftWrapping;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductInGiftFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductInGift::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),  // Tạo sản phẩm ngẫu nhiên
            'gift_id' => GiftWrapping::factory(), // Tạo gói quà ngẫu nhiên
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 5, 100), // Tạo giá ngẫu nhiên
        ];
    }
}
