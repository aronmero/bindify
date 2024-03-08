<?php

namespace Database\Factories;

use App\Models\Commerce;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $usuarioId = Customer::inRandomOrder()
            ->whereNotExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('reviews')
                    ->whereRaw('reviews.user_id = customers.user_id')
                    ->whereRaw('reviews.commerce_id = commerces.id');
            })
            ->pluck('user_id')
            ->first();
        $commerceId = Commerce::whereNotIn('user_id', function ($query) {
            $query->select('user_id')->from('commerces')->where();
        })->inRandomOrder()->pluck('user_id')->first();

        return [

            'user_id' => $usuarioId,
            'commerce_id' => $commerceId,
            'comment' => $this->faker->sentence(),
            'note' => $this->faker->numberBetween(1, 5),

        ];
    }
}
