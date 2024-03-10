<?php

namespace Database\Seeders;

use App\Models\Commerce;
use App\Models\Hashtag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommercesHashtagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $commerces = Commerce::all();

        for ($i = 1; $i <= 30; $i++) {

            $hashtagId = Hashtag::leftJoin('commerces-hashtags', 'hashtags.id', '=', 'commerces-hashtags.hashtag_id')
            ->selectRaw('hashtags.id as hashtag_id, COUNT(hashtags.id) as hashtag_count')
            ->groupBy('hashtags.id')
            ->havingRaw('hashtag_count < ?', [$commerces->count()])
            ->inRandomOrder()
            ->first();

            $commerceId = Commerce::leftJoin(
                DB::raw('(SELECT DISTINCT commerce_id FROM `commerces-hashtags` WHERE hashtag_id = ' . $hashtagId->hashtag_id . ') AS commerces_hashtags'),
                function ($join) {
                    $join->on('commerces.user_id', '=', 'commerces_hashtags.commerce_id');
                }
            )
            ->select('commerces.user_id as commerceId')
            ->whereNull('commerces_hashtags.commerce_id')
            ->inRandomOrder()
            ->first();

            DB::table('commerces-hashtags')->insert([
                'commerce_id' => $commerceId->commerceId,
                'hashtag_id' => $hashtagId->hashtag_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
