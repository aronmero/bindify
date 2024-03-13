<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;
use App\Events\ModelCreated;
use App\Models\Follower;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $factory = FakerFactory::create();
        $users = User::all();

        for ($i = 1; $i <= 80; $i++) {

            $followsId = User::leftJoin('followers', 'users.id', '=', 'followers.follows_id')
            ->selectRaw('users.id as followsId, COUNT(followers.follows_id) as follows_count')
            ->groupBy('users.id')
            ->havingRaw('follows_count < ?', [$users->count()-1])
            ->inRandomOrder()
            ->first();

            $followerId = User::leftJoin(
                DB::raw('(SELECT DISTINCT follower_id FROM followers WHERE follows_id = ' . $followsId->followsId . ') AS followers'),
                function ($join) {
                    $join->on('users.id', '=', 'followers.follower_id');
                }
            )
            ->select('users.id as followerId')
            ->whereNull('followers.follower_id')
            ->where('users.id', '!=', $followsId->followsId)
            ->inRandomOrder()
            ->first();

            $follower = Follower::create([
                'follows_id' => $followsId->followsId,
                'follower_id' => $followerId->followerId,
                'favorito' => $factory->boolean,
            ]);

            event(new ModelCreated($follower));

        }
    }
}
