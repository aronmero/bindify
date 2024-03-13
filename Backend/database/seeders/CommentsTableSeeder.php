<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Events\ModelCreated;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cantidad = 200;

        for ($i = 0; $i < $cantidad; $i++) {
            $comment = Comment::factory()->create();
            event(new ModelCreated($comment));
        }
    }
}
