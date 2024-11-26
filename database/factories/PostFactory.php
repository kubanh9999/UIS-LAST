<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::inRandomOrder()->first();
        $userId = $user ? $user->id : \App\Models\User::factory()->create()->id;

        // Lấy một category ngẫu nhiên hoặc tạo một mới nếu không có
        $category = \App\Models\PostCategory::inRandomOrder()->first();
        $categoryId = $category ? $category->id : \App\Models\PostCategory::factory()->create()->id;

        return [
            'title' => $this->faker->sentence,
            'user_id' => $userId,
            'category_id' => $categoryId,
            'image' => $this->faker->imageUrl(),
            'content' => substr($this->faker->paragraphs(3, true), 0, 255), 
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
        ];
    }
}
