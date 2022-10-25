<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Articles>
 */
class ArticlesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
                'title' => fake()->title(),
                'content' => fake()->sentence(),
                'image' => 'gambar.jpg', 
                'user_id' => User::factory()->create()->id,
                'category_id' => Categories::factory()->create()->id
        ];
    }
}
