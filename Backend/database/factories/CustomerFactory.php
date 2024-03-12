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

        $userId = User::leftJoin('customers', 'customers.user_id', '=', 'users.id')
        ->leftJoin('commerces', 'commerces.user_id', '=', 'users.id')
        ->whereNull('customers.user_id')
        ->whereNull('commerces.user_id')
        ->pluck('users.id')
        ->first();

        $user = User::find($userId);
        $user->assignRole('customer');

        return [
            'user_id' => $userId,
            'gender' => $this->faker->randomElement(['M', 'H']),
            'birth_date' => $this->faker->date(),
        ];
    }
}
