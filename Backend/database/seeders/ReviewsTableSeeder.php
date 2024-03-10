<?php

namespace Database\Seeders;

use App\Models\Commerce;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cantidad = 100;

        for ($i = 0; $i < $cantidad; $i++) {
            $review = Review::factory()->create();
            
          
            $commerceId = $review->commerce_id;
            $commerce = Commerce::find($commerceId);
            $reviews = Review::where('commerce_id', $commerceId)->get();
            $totalScore = $reviews->sum('note');
            $averageScore = $totalScore / $reviews->count();
            
            
            $commerce->avg = $averageScore;
            $commerce->save();
        }
    }
}
