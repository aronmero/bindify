<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;

class UsersPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $factory = FakerFactory::create();

        for ($i = 1; $i <= 60; $i++) {

            DB::table('users-posts')->insert([
                'user_id' => $factory->numberBetween(1, User::count()),
                'post_id' => $factory->numberBetween(1, Post::count())
            ]);
        }
    }
}
