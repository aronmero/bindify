<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $auxReply = rand(1, 10);
        $father_id = null;
        $post_id = $this->faker->numberBetween(1, Post::count());

        if (Comment::count()>1) {
            if($auxReply < 5){
                $father_id = Comment::where('post_id', '=', $post_id)->inRandomOrder()
                ->first();
                $father_id = ($father_id == null /*|| $father_id->father != null*/)?$father_id->id:null;
            }
        }

        $auxActive = rand(1, 12);
        $active = false;

        if($auxActive > 1){
            $active = true;
        }

        return [
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'post_id' => $post_id,
            'content' => $this->faker->text(),
            'father_id' => $father_id,
            'active' => $active,
        ];
    }
}
