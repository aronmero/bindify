<?php

namespace Database\Factories;

use App\Models\Commerce;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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

        $commerces = Commerce::all();

        $userId = Customer::leftJoin('reviews', 'customers.user_id', '=', 'reviews.user_id')
        ->selectRaw('customers.user_id as user_id, COUNT(customers.user_id) as customer_count')
        ->groupBy('customers.user_id')
        ->havingRaw('customer_count < ?', [$commerces->count()])
        ->inRandomOrder()
        ->first();

        $commerceId = Commerce::leftJoin(
            DB::raw('(SELECT DISTINCT commerce_id FROM reviews WHERE user_id = ' . $userId->user_id . ') AS user_reviews'), function($join) {
            $join->on('commerces.user_id', '=', 'user_reviews.commerce_id');
        })
        ->select('commerces.user_id as commerce_id')
        ->whereNull('user_reviews.commerce_id')
        ->inRandomOrder()
        ->first();

        return [
            'user_id' => $userId,
            'commerce_id' => $commerceId->commerce_id,
            'comment' => $this->faker->sentence(),
            'note' => $this->faker->numberBetween(1, 5),
        ];
    }
}
