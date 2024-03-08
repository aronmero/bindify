<?php

namespace Database\Factories;

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
        $userId = User::whereNotIn('id', function ($query) {
            $query->select('user_id')->from('commerces')
                ->unionAll($query->select('user_id')->from('customers'));
        })->pluck('id')->first();

        return [
            'user_id' => $userId,
            'address' => $this->faker->address,
            'description' => $this->faker->sentence,
            'verification_token_id' => $this->faker->randomNumber(),
            'verificated' => $this->faker->boolean,
            'schedule' => $this->faker->time('H:i:s'),
            'active' => $this->faker->boolean,
        ];
    }
}
