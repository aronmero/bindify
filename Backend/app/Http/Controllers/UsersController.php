<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Scripts\Utils;
use App\Models\Category;
use App\Models\Commerce;
use App\Models\Customer;
use App\Models\Follower;
use App\Models\Municipality;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:admin")->only("destroy");
    }
    /**
     * Muestra la información de un usuario específico.
     *
     * Esta función recibe el nombre de usuario y busca en la base de datos la información correspondiente.
     * Dependiendo del tipo de usuario (cliente o comercio), recopila y devuelve información relevante dependiendo si es un cliente o un comercio en formato JSON.
     * Si no se encuentra el usuario, devuelve un mensaje de error y un estado 404.
     *
     * @param string $username - El nombre de usuario del usuario a mostrar.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON con la información del usuario o un mensaje de error.
     *
     * Ejemplo de respuesta exitosa:
     *
     * @response 200 {
     *   "status": true,
     *   "data": {
     *       "email": "correo@example.com",
     *       "phone": "123456789",
     *       "municipality_name": "NombreMunicipio",
     *       "avatar": "url_avatar",
     *       "username": "nombre_usuario",
     *       "name": "Nombre",
     *       "gender": "Género",
     *       "birth_date": "Fecha de Nacimiento",
     *       "address": "Dirección",
     *       "description": "Descripción del Comercio",
     *       "categories_name": "Nombre de la Categoría",
     *       "schedule": "Horario",
     *       "active": "Estado de Actividad"
     *   }
     * }
     *
     * Ejemplo de respuesta de error:
     *
     * @response 404 {
     *   "status": false,
     *   "error": "Usuario no encontrado"
     * }
     */

    public function show(string $username)
    {
        try {
            $user = User::where("username", $username)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Usuario no encontrado",
                "error" => $th->getMessage(),
            ], 404);
        }

        $userRol = $user->getRoleNames()[0];

        if ($userRol == "customer") {

            try {

                $customer = Customer::join('users', 'customers.user_id', '=', 'users.id')
                    ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                    ->select(
                        'email',
                        'phone',
                        'municipalities.name AS municipality_name',
                        'avatar',
                        'banner',
                        'username',
                        'users.name',
                        'gender',
                        'birth_date'
                    )
                    ->where('users.username', '=', $username)
                    ->firstOrFail();
                $customer->tipo = 'customer';

                return response()->json([
                    "status" => true,
                    "data" => $customer
                ], 200);
            } catch (QueryException $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500);
            } catch (Exception $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 404);
            }
        } else {

            try {

                $commerce = Commerce::leftJoin('reviews', 'commerces.user_id', '=', 'reviews.commerce_id')
                    ->join('users', 'commerces.user_id', '=', 'users.id')
                    ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                    ->join('categories', 'commerces.category_id', '=', 'categories.id')
                    ->select(
                        'email',
                        'phone',
                        'municipalities.name AS municipality_name',
                        'avatar',
                        'banner',
                        'username',
                        'users.name',
                        'address',
                        'commerces.description',
                        'categories.name AS categories_name',
                        'schedule',
                        'commerces.active',
                        'commerces.avg',
                        DB::raw('count(reviews.commerce_id) as review_count')

                    )
                    ->where('users.username', '=', $username)
                    ->groupBy(
                        'email',
                        'phone',
                        'municipalities.name',
                        'avatar',
                        'banner',
                        'username',
                        'users.name',
                        'address',
                        'commerces.description',
                        'categories.name',
                        'schedule',
                        'commerces.active',
                        'commerces.avg',
                    )
                    ->get();


                $commerce->each(function ($commerce) {
                    $user = User::where("username", $commerce->username)->firstOrFail();
                    $userRol = $user->getRoleNames()[0];
                    $commerce->tipo = ($userRol == "ayuntamiento") ? "ayuntamiento" : "commerce";
                    $commerceId = Commerce::join('users', 'commerces.user_id', '=', 'users.id')
                        ->select('user_id')
                        ->where('users.username', '=', $commerce->username)
                        ->firstOrFail();

                    $hashtags = Commerce::find($commerceId->user_id)->hashtags->pluck('name')->toArray();
                    $commerce->hashtags = $hashtags;

                    //Seguido
                    $auth = Auth::user();
                    $userId = User::where('username', $commerce->username)->firstOrFail()->id;

                    $seguido = $auth->follows()->where('follows_id', '=', $userId)->first();

                    if ($seguido) {
                        $commerce->followed = true;
                        if (Follower::where('follows_id', $userId)->where('follower_id', $auth->id)->first()->favorito) {
                            $commerce->favorite = true;
                        } else {
                            $commerce->favorite = false;
                        }
                    } else {
                        $commerce->followed = false;
                    }

                });

                return response()->json([
                    "status" => true,
                    "data" => $commerce
                ], 200);
            } catch (QueryException $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500);
            } catch (Exception $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 404);
            }
        }
    }

    /**
     * Actualiza la información de un usuario específico.
     *
     * Comprueba que un usuario por su nombre sea de tipo costumer o commercie
     * para luego poder actualizar los campos respectivos de cada uno
     *
     * @param \Illuminate\Http\Request $request - La solicitud HTTP con los datos de actualización.
     * @param string $username - El nombre de usuario del usuario a actualizar.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON con el resultado de la actualización o un mensaje de error.
     *
     *@response 200 {
     *   "status": true,
     *   "data": "Datos del usuario recien actualizado"
     * }
     * * @response 500 {
     *   "status": false,
     *   "error": "Error en la base de datos"
     * }
     * @response 404 {
     *   "status": false,
     *   "error": "Usuario no encontrado"
     * }
     *
     */


    public function update(UpdateUserRequest $request, string $username)
    {
        try {

            // Elimina campos que no queremos actualizar
            $request->request->remove("username");
            $request->request->remove("phone");
            $request->request->remove("email");

            // Busca al usuario por su nombre de usuario
            $user = User::where("username", $username)->firstOrFail();
            $user->municipality_id = Municipality::where('name', '=', $request->municipality)->first()->id;

            // Revisa si el usuario es él mismo el que se va a cambiar
            if (Auth::user()->id != $user->id) {
                return response()->json(["status" => false, "message" => "No autorizado"], 401);
            }

            // Determina el rol del usuario
            if ($user->getRoleNames() == "customer") {

                // Si el usuario es un cliente, actualiza los detalles como cliente
                $customer = Customer::where('user_id', $user->id)->first();
                $customer->fill($request->except('avatar', 'banner'));

                if ($request->hasFile('avatar')) {
                    $avatar = $request->file('avatar');
                    Storage::disk('avatars')->putFileAs($request->username, $avatar, 'imagenPerfil.webp');
                    $customer->avatar = asset('storage/avatars/' . $request->username . '/imagenPerfil.webp');
                }

                if ($request->hasFile('banner')) {
                    $banner = $request->file('banner');
                    Storage::disk('avatars')->putFileAs($request->username, $banner, 'banner.webp');
                    $customer->banner = asset('storage/avatars/' . $request->username . '/banner.webp');
                }

                $customer->save();
                $updatedUser = $customer->user;

            } else {
                // Si el usuario es un comercio, actualiza los detalles como comercio
                $commerce = Commerce::where('user_id', $user->id)->first();

                $commerce->fill($request->except('avatar', 'banner', 'category', 'municipality'));

                if ($request->hasFile('avatar')) {
                    $avatar = $request->file('avatar');
                    Storage::disk('avatars')->putFileAs($request->username, $avatar, 'imagenPerfil.webp');
                    $commerce->avatar = asset('storage/avatars/' . $request->username . '/imagenPerfil.webp');
                }

                if ($request->hasFile('banner')) {
                    $banner = $request->file('banner');
                    Storage::disk('avatars')->putFileAs($request->username, $banner, 'banner.webp');
                    $commerce->banner = asset('storage/avatars/' . $request->username . '/banner.webp');
                }

                $commerce->category_id = Category::where('name', '=', $request->category)->first()->id;
                $commerce->save();
                $updatedUser = $commerce->user;
            }

            // Devuelve una respuesta JSON exitosa con los detalles del usuario actualizados
            return response()->json(["status" => true, "message" => "Usuario actualizado Correctamente:", "data" => $updatedUser], 200);
        } catch (QueryException $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de error de base de datos
            return response()->json(["status" => false, "message" => "Error en la base de datos :", "error" => $e->getMessage()], 500);
        } catch (Exception $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de otra excepción
            return response()->json(["status" => false, "message" => "Usuario no encontrado en la base de datos:", "error" => $e->getMessage()], 404);
        }
    }

    /**
     * Elimina un usuario específico.
     *
     * Si el usuario es un costumer , se elimina de la base de datos directamente
     * pero si es un Commerce , cambia el valor del campo active a false
     * por lo que no se borra de la base de datos
     *
     * @param string $username - El nombre de usuario del usuario a eliminar.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON con el resultado de la eliminación o un mensaje de error.
     *
     *  *@response 200 {
     *   "status": true,
     *   "data": "Usuario eliminado exitosamente"
     * }
     * * @response 500 {
     *   "status": false,
     *   "error": "Error en la base de datos"
     * }
     * @response 404 {
     *   "status": false,
     *   "error": "Usuario no encontrado"
     * }
     *
     */


    public function destroy(string $username)
    {
        try {
            // Busca al usuario por su nombre de usuario
            $user = User::where("username", $username)->firstOrFail();

            // Determina el rol del usuario
            if ($user->getRoleNames() == "customer") {
                // Si el usuario es un cliente, elimina el registro de la tabla 'customers'
                $customer = Customer::where('user_id', $user->id)->first();
                $user->delete();
            } else {
                // Si el usuario es un comercio, actualiza el campo 'active' a false
                $commerce = Commerce::where('user_id', $user->id)->first();
                $commerce->active = false;
                $commerce->save();
            }

            // Devuelve una respuesta JSON exitosa
            return response()->json(["status" => true, "message" => "Usuario eliminado exitosamente"], 200);
        } catch (QueryException $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de error de base de datos
            return response()->json(["status" => false, "message" => "Error en la base de datos :", "error" => $e->getMessage()], 500);
        } catch (Exception $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de otra excepción
            return response()->json(["status" => false, "message" => "Usuario no encontrado en la base de datos:", "error" => $e->getMessage()], 404);
        }
    }

    /**
     * Retorna las publicaciones de un usuario específico.
     *
     * Este método recupera las publicaciones de un usuario específico, identificado por su nombre de usuario.
     * Las publicaciones incluyen información como la imagen, título, descripción, tipo, fechas de inicio y fin,
     * fecha de creación, nombre de usuario y avatar. Además, se obtienen los hashtags asociados a cada publicación.
     *----------------------------------------------------------------------
     * @param string $username
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     * "status": true,
     * "data": [
     * {
     * "post_id": "ID_de_la_publicación",
     * "image": "imagen_de_la_publicación",
     * "title": "título_de_la_publicación",
     * "description": "descripción_de_la_publicación",
     * "name": "nombre_del_tipo_de_publicación",
     * "start_date": "fecha_de_inicio_de_la_publicación",
     * "end_date": "fecha_de_finalización_de_la_publicación",
     * "created_at": "fecha_de_creación_de_la_publicación",
     * "username": "nombre_de_usuario",
     * "user_id": "ID_del_usuario",
     * "avatar": "avatar_del_usuario",
     * "hashtags": ["hashtag1", "hashtag2", ...]
     * },
     * ...
     * ]
     * }
     *
     * @response 404 {
     * "status": false,
     * "message": "Usuario no encontrado en la base de datos: mensaje_de_error"
     * }
     *
     * @response 500 {
     * "status": false,
     * "message": "Error en la base de datos : mensaje_de_error"
     * }
     */
    public function posts(string $username)
    {
        try {

            $user = Auth::user();

            $id = Commerce::join('users', 'commerces.user_id', '=', 'users.id')
                ->select('user_id')
                ->where('users.username', '=', $username)
                ->firstOrFail();


            $posts = Post::join('users-posts', 'users-posts.post_id', '=', 'posts.id')
                ->join('users', 'users.id', '=', 'users-posts.user_id')
                ->join('post_types', 'post_types.id', '=', 'posts.post_type_id')
                ->join('commerces', 'commerces.user_id', '=', 'users-posts.user_id')
                ->select(
                    'posts.id AS post_id',
                    'posts.image',
                    'posts.title',
                    'posts.description',
                    'posts.description',
                    'post_types.name',
                    'posts.start_date',
                    'posts.end_date',
                    'posts.created_at',
                    'users.username',
                    'users.id AS user_id',
                    'users.avatar'
                )
                ->where('users-posts.user_id', '=', $id->user_id)->where('posts.post_type_id', '=', 1)->where('commerces.active', '=', 1);



            if ($user->username != $username) {
                $posts = $posts->where('posts.active', '=', true);
            }

            $posts = $posts->orderBy('posts.created_at', 'desc')
                ->get();

            $posts->each(function ($post) {
                $post->hashtags = Post::find($post->post_id)->hashtags->pluck('name')->toArray();
                $post->post_id = Utils::Crypt($post->post_id);
                $user = User::where('username', $post->username)->first();
                $post->userRol = $user->getRoleNames()[0];
            });
            return response()->json(["status" => true, "data" => $posts], 200);
        } catch (QueryException $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de error de base de datos
            return response()->json(["status" => false, "message" => "Error en la base de datos :", "error" => $e->getMessage()], 500);
        } catch (Exception $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de otra excepción
            return response()->json(["status" => false, "message" => "Usuario no encontrado en la base de datos:", "error" => $e->getMessage()], 404);
        }
    }


    /**
     * Retorna los eventos asociados a un usuario específico.
     *
     * Este método recupera los eventos asociados a un usuario específico, identificado por su nombre de usuario.
     * Los eventos incluyen información como la imagen, título, descripción, tipo, fechas de inicio y fin,
     * fecha de creación, nombre de usuario y avatar. Además, se obtienen los hashtags asociados a cada evento.
     *
     * @param string $username
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     * "status": true,
     * "data": [
     * {
     * "post_id": "ID_del_evento",
     * "image": "imagen_del_evento",
     * "title": "título_del_evento",
     * "description": "descripción_del_evento",
     * "name": "nombre_del_tipo_de_evento",
     * "start_date": "fecha_de_inicio_del_evento",
     * "end_date": "fecha_de_finalización_del_evento",
     * "created_at": "fecha_de_creación_del_evento",
     * "username": "nombre_de_usuario",
     * "user_id": "ID_del_usuario",
     * "avatar": "avatar_del_usuario",
     * "hashtags": ["hashtag1", "hashtag2", ...]
     * },
     * ...
     * ]
     * }
     *
     * @response 404 {
     * "status": false,
     * "message": "Usuario no encontrado en la base de datos: mensaje_de_error"
     * }
     *
     * @response 500 {
     * "status": false,
     * "message": "Error en la base de datos : mensaje_de_error"
     * }
     */

    public function events(string $username)
    {
        try {

            $user = Auth::user();

            $id = Commerce::join('users', 'commerces.user_id', '=', 'users.id')
                ->select('user_id')
                ->where('users.username', '=', $username)
                ->firstOrFail();


            $posts = Post::join('users-posts', 'users-posts.post_id', '=', 'posts.id')
                ->join('users', 'users.id', '=', 'users-posts.user_id')
                ->join('post_types', 'post_types.id', '=', 'posts.post_type_id')
                ->join('commerces', 'commerces.user_id', '=', 'users-posts.user_id')
                ->select(
                    'posts.id AS post_id',
                    'posts.image',
                    'posts.title',
                    'posts.description',
                    'posts.description',
                    'post_types.name',
                    'posts.start_date',
                    'posts.end_date',
                    'posts.created_at',
                    'users.username',
                    'users.id AS user_id',
                    'users.avatar'
                )
                ->where('users-posts.user_id', '=', $id->user_id)->where('posts.post_type_id', '=', 2)->where('commerces.active', '=', 1);



            if ($user->username != $username) {
                $posts = $posts->where('posts.active', '=', true);
            }

            $posts = $posts->orderBy('posts.created_at', 'desc')
                ->get();

            $posts->each(function ($post) {
                $post->hashtags = Post::find($post->post_id)->hashtags->pluck('name')->toArray();
                $post->post_id = Utils::Crypt($post->post_id);
                $user = User::where('username', $post->username)->first();
                $post->userRol = $user->getRoleNames()[0];
            });

            return response()->json([
                "status" => true,
                "data" => $posts
            ], 200);
        } catch (QueryException $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de error de base de datos
            return response()->json(["status" => false, "message" => "Error en la base de datos :", "error" => $e->getMessage()], 500);
        } catch (Exception $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de otra excepción
            return response()->json(["status" => false, "message" => "Usuario no encontrado en la base de datos:", "error" => $e->getMessage()], 404);
        }
    }

    /**
     * Retorna el perfil del usuario autenticado.
     *
     * Este método recupera y devuelve el perfil del usuario autenticado.
     * Si el usuario es un cliente, se devuelve la información relacionada con el cliente,
     * incluyendo correo electrónico, teléfono, municipio, avatar, banner, nombre de usuario,
     * nombre, género y fecha de nacimiento.
     * Si el usuario es un comercio, se devuelve la información relacionada con el comercio,
     * incluyendo correo electrónico, teléfono, municipio, avatar, banner, nombre de usuario,
     * nombre, dirección, descripción del comercio, categoría, horario, estado activo, promedio de calificación
     * y recuento de reseñas.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     * "status": true,
     * "data": {
     * "email": "correo_electrónico",
     * "phone": "número_de_teléfono",
     * "municipality_name": "nombre_del_municipio",
     * "avatar": "avatar_del_usuario",
     * "banner": "banner_del_usuario",
     * "username": "nombre_de_usuario",
     * "name": "nombre_del_usuario",
     * "gender": "género_del_usuario",
     * "birth_date": "fecha_de_nacimiento_del_usuario",
     * "address": "dirección_del_comercio",
     * "description": "descripción_del_comercio",
     * "categories_name": "nombre_de_la_categoría",
     * "schedule": "horario_del_comercio",
     * "active": true,
     * "avg": "promedio_de_calificación_del_comercio",
     * "review_count": "recuento_de_reseñas_del_comercio",
     * "hashtags": ["hashtag1", "hashtag2", ...]
     * }
     * }
     *
     * @response 404 {
     * "status": false,
     * "message": "Usuario no encontrado: mensaje_de_error"
     * }
     *
     * @response 500 {
     * "status": false,
     * "message": "Error en la base de datos: mensaje_de_error"
     * }
     */
    public function profile()
    {
        $username = Auth::user()->username;
        try {
            $user = User::where("username", $username)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json(["status" => false, "message" => "Usuario no encontrado", "error" => $th->getMessage(),], 404);
        }

        $userRol = $user->getRoleNames()[0];

        if ($userRol == "customer") {

            try {

                $customer = Customer::join('users', 'customers.user_id', '=', 'users.id')
                    ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                    ->select(
                        'email',
                        'phone',
                        'municipalities.name AS municipality_name',
                        'avatar',
                        'banner',
                        'username',
                        'users.name',
                        'gender',
                        'birth_date'
                    )
                    ->where('users.username', '=', $username)
                    ->firstOrFail();

                return response()->json(["status" => true, "data" => $customer], 200);
            } catch (QueryException $e) {

                return response()->json(["status" => false, "error" => $e->getMessage()], 500);
            } catch (Exception $e) {

                return response()->json(["status" => false, "error" => $e->getMessage()], 404);
            }
        } else {

            try {

                $commerce = Commerce::leftJoin('reviews', 'commerces.user_id', '=', 'reviews.commerce_id')
                    ->join('users', 'commerces.user_id', '=', 'users.id')
                    ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                    ->join('categories', 'commerces.category_id', '=', 'categories.id')
                    ->select(
                        'email',
                        'phone',
                        'municipalities.name AS municipality_name',
                        'avatar',
                        'banner',
                        'username',
                        'users.name',
                        'address',
                        'commerces.description',
                        'categories.name AS categories_name',
                        'schedule',
                        'commerces.active',
                        'commerces.avg',
                        DB::raw('count(reviews.commerce_id) as review_count')

                    )
                    ->where('users.username', '=', $username)
                    ->groupBy(
                        'email',
                        'phone',
                        'municipalities.name',
                        'avatar',
                        'banner',
                        'username',
                        'users.name',
                        'address',
                        'commerces.description',
                        'categories.name',
                        'schedule',
                        'commerces.active',
                        'commerces.avg',
                    )
                    ->get();

                $commerce->each(function ($commerce) {

                    $user = User::where("username", $commerce->username)->firstOrFail();
                    $userRol = $user->getRoleNames()[0];
                    $commerce->tipo = ($userRol == "ayuntamiento") ? "ayuntamiento" : "commerce";
                    $commerceId = Commerce::join('users', 'commerces.user_id', '=', 'users.id')
                        ->select('user_id')
                        ->where('users.username', '=', $commerce->username)
                        ->firstOrFail();

                    $hashtags = Commerce::find($commerceId->user_id)->hashtags->pluck('name')->toArray();
                    $commerce->hashtags = $hashtags;
                });
                return response()->json([
                    "status" => true,
                    "data" => $commerce
                ], 200);
            } catch (QueryException $e) {
                return response()->json(["status" => false, "error" => $e->getMessage()], 500);
            } catch (Exception $e) {
                return response()->json(["status" => false, "error" => $e->getMessage()], 404);
            }
        }
    }
}
