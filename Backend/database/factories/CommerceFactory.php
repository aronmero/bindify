<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\Verification_token;
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

        $aux1 = rand(1, 10);

        $verification_token_id = null;


        if ($aux1 == 1) {

            $verification_token_id = Verification_token::select('id')
            ->inRandomOrder()
            ->first();

        }

        $aux2 = rand(1, 12);

        $active = false;

        if($aux2 > 1){
            $active = true;
        }

        return [
            'user_id' => $userId,
            'address' => $this->faker->address,
            'description' => $this->faker->sentence,
            'verification_token_id' => $verification_token_id,
            'category_id' => rand(1, Category::count()),
            'verificated' => $this->faker->boolean,
            'schedule' => null,
            'active' => $active,
        ];
    }
}
