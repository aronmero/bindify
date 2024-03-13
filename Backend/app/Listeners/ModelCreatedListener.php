<?php

namespace App\Listeners;

use App\Events\ModelCreated;
use App\Models\Comment;
use App\Models\Follower;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Crypt;

class ModelCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ModelCreated $event): void
    {
        $model = $event->model;

        switch (get_class($model)) {

            // Verificar si el modelo es un comentario
            case Comment::class:

                $post = Post::where('id', '=', $model->post_id)->first();
                $id = $post->users()->first()->id;

                if ($id != $model->user_id) {
                    Notification::create([
                        'user_id' => $id,
                        'element_id' => $model->id,
                        'element_type' => 'App\\Models\\Comment'
                    ]);
                }

                break;

            // Verificar si el modelo es una review
            case Review::class:

                Notification::create([
                    'user_id' => $model->commerce_id,
                    'element_id' => $model->id,
                    'element_type' => 'App\\Models\\Review'
                ]);

                break;

            // Verificar si el modelo es un follower
            case Follower::class:

                Notification::create([
                    'user_id' => $model->follows_id,
                    'element_id' => $model->follower_id,
                    'element_type' => 'App\\Models\\Follower'
                ]);

                break;

            // Verificar si el modelo es un post
            case Post::class:

                $post = Post::where('id', '=', $model->id)->first();
                $id = $post->users->first()->id;
                $followers = User::where('id', '=', $id)->first()->follower;

                if ($followers) {

                    $ids = [];

                    foreach ($followers as $seguidores) {
                        $ids[] = $seguidores->id;
                    }

                    foreach ($ids as $id) {

                        Notification::create([
                            'user_id' => $id,
                            'element_id' => $model->id,
                            'element_type' => 'App\\Models\\Post'
                        ]);
                    }
                }

                break;
        }
    }
}
