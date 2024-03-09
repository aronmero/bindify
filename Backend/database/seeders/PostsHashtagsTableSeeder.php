<?php

namespace Database\Seeders;

use App\Models\Hashtag;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsHashtagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $posts = Post::all();

        for ($i = 1; $i <= 80; $i++) {

            $hashtagId = Hashtag::leftJoin('posts-hashtags', 'hashtags.id', '=', 'posts-hashtags.hashtag_id')
            ->selectRaw('hashtags.id as hashtag_id, COUNT(hashtags.id) as hashtag_count')
            ->groupBy('hashtags.id')
            ->havingRaw('hashtag_count < ?', [$posts->count()])
            ->inRandomOrder()
            ->first();

            $postId = Post::leftJoin(
                DB::raw('(SELECT DISTINCT post_id FROM `posts-hashtags` WHERE hashtag_id = ' . $hashtagId->hashtag_id . ') AS post_hashtags'),
                function ($join) {
                    $join->on('posts.id', '=', 'post_hashtags.post_id');
                }
            )
            ->select('posts.id as postId')
            ->whereNull('post_hashtags.post_id')
            ->inRandomOrder()
            ->first();

            DB::table('posts-hashtags')->insert([
                'post_id' => $postId->postId,
                'hashtag_id' => $hashtagId->hashtag_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
