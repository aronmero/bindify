<?php

namespace Database\Seeders;

use App\Models\Commerce;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cantidad = 50;

        for ($i = 0; $i < $cantidad; $i++) {
            $post = Post::factory()->create();
            $userId = Commerce::select('user_id')
            ->inRandomOrder()
            ->first();
            $user = User::find($userId);
            $post = $post->users()->attach($user);
        }
    }
}
