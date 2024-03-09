<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'post_id' => $this->faker->numberBetween(1, Post::count()),
            'content' => $this->faker->text(),
            'comment_id' => null,
            'active' => $this->faker->boolean(),
        ];
    }
}
