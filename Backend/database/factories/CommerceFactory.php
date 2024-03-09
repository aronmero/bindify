<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commerce>
 */
class CommerceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::leftJoin('customers', 'customers.user_id', '=', 'users.id')
        ->leftJoin('commerces', 'commerces.user_id', '=', 'users.id')
        ->whereNull('customers.user_id')
        ->whereNull('commerces.user_id')
        ->pluck('users.id')
        ->first();

        $user = User::find($userId);
        $user->assignRole('commerce');

        $postsNotInUsersPosts = Post::whereNotIn('id', function($query) {
            $query->select('post_id')->from('users-posts');
        })->get();

        return [
            'user_id' => $userId,
            'address' => $this->faker->address,
            'description' => $this->faker->sentence,
            'verification_token_id' => 1,
            'category_id' => rand(1, Category::count()),
            'verificated' => $this->faker->boolean,
            'schedule' => null,
            'active' => $this->faker->boolean,
        ];
    }
}
