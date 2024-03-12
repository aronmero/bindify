<?php

namespace Database\Factories;

use App\Models\Post_type;
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

        $aux = rand(1, 12);

        $active = false;

        if($aux > 1){
            $active = true;
        }

        return [
            'image' => $this->faker->imageUrl(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'post_type_id' => $this->faker->numberBetween(1, Post_type::count()),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'active' => $active,
        ];
    }
}
