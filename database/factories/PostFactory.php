<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(100, 9999),
            'lead' => fake()->sentence(10),
            'content' => fake()->paragraphs(3, true),
            'author' => fake()->name(),
            'photo' => fake()->randomElement(['📝', '💡', '🚀', '🎯']),
            'is_published' => true,
        ];
    }
}
