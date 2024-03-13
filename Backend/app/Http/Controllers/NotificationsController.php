<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Follower;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Review;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class NotificationsController extends Controller
{

    /**
     * Muestra la lista de notificaciones del usuario.
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": true,
     *     "data": [
     *         {
     *             notificación 1
     *         },
     *         ...
     *     ]
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "message": "Error: Mensaje de error"
     * }
     */
    public function index()
    {
        try {

            $user = Auth::user();

            $notificaciones = $user->notifications;

            foreach ($notificaciones as $notificacion) {

                $user = User::find($notificacion->user_id);
                $notificacion->seen = ($notificacion->seen == 1) ? true : false;

                switch ($notificacion->element_type) {

                        // Verificar si la notificación es un comentario
                    case 'App\\Models\\Comment':

                        $comment = Comment::where('id', '=', $notificacion->element_id)->first();
                        $post = $comment->post;

                        $notificacion->id = Crypt::encryptString($notificacion->id);

                        $notificacion->username = $comment->user->username;
                        $notificacion->avatar = $comment->user->avatar;
                        $notificacion->content = $comment->content;
                        $notificacion->post_id = Crypt::encryptString($post->id);
                        $notificacion->post_title = $post->post_title;
                        $notificacion->post_imagen = $post->image;

                        break;

                        // Verificar si la notificación es una review
                    case 'App\\Models\\Review':

                        $review = Review::where('id', '=', $notificacion->element_id)->first();

                        $notificacion->username = $review->user->username;
                        $notificacion->avatar = $review->user->avatar;
                        $notificacion->review_id = Crypt::encryptString($review->id);
                        $notificacion->comment = $review->comment;
                        $notificacion->note = $review->note;

                        break;

                        // Verificar si la notificación es un follower
                    case 'App\\Models\\Follower':

                        $user = User::where('id', '=', $notificacion->element_id)->first();

                        $notificacion->username = $user->username;
                        $notificacion->avatar = $user->avatar;

                        break;

                        // Verificar si la notificación es sobre un post
                    case 'App\\Models\\Post':

                        $post = Post::where('id', '=', $notificacion->element_id)->first();

                        $notificacion->username = $post->users->first()->username;
                        $notificacion->avatar = $post->users->first()->avatar;
                        $notificacion->post_imagen = $post->image;
                        $notificacion->municipality = $post->users->first()->municipality->name;
                        $notificacion->post = Crypt::encryptString($post->id);
                        $notificacion->post_type = $post->post_type->name;

                        break;
                }

                unset($notificacion->updated_at);
                unset($notificacion->id);
                unset($notificacion->user_id);
                unset($notificacion->element_id);
                unset($notificacion->element_type);
            }

            return response()->json([
                'status' => true,
                'data' => $notificaciones,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Error: " . $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Muestra la lista de notificaciones del usuario.
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": false,
     *     "message": "Notificación revisada"
     * }
     *
     * @response 403 {
     *     "status": false,
     *     "message": "Notificación ya revisada"
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "message": "Notificación no encontrada"
     * }
     *
     * @response 500 {
     *     "status": false,
     *     "message": "Error de Decrypt"
     * }
     *
     * @response 500 {
     *     "status": false,
     *     "message": "Error: Mensaje de error"
     * }
     */
    public function check(string $id)
    {
        try {

            try {
                $id = Crypt::decryptString($id);
            } catch (DecryptException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error de Decrypt',
                ], 500);
            }

            $notificacion = Notification::where('id', $id)->firstOrFail()->favorito;

            if ($notificacion->seen) {
                return response()->json([
                    'status' => true,
                    'message' => 'Notificación ya revisada',
                ], 403);
            }
            return response()->json([
                'status' => true,
                'message' => 'Notificación revisada',
            ], 200);


        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => "Notificación no encontrada",
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Error: " . $e->getMessage(),
            ], 500);
        }
    }
}