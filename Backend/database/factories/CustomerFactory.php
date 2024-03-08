<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
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
            'gender' => $this->faker->randomElement(['male', 'female']),
            'birth_date' => $this->faker->date(),
        ];
    }
}
