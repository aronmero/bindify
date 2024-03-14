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
     * @OA\Get(
     *     path="/user/{username}",
     *     summary="Muestra la información de un usuario específico.",
     *     description="Esta función recibe el nombre de usuario y busca en la base de datos la información correspondiente. Dependiendo del tipo de usuario (cliente o comercio), recopila y devuelve información relevante dependiendo si es un cliente o un comercio en formato JSON. Si no se encuentra el usuario, devuelve un mensaje de error y un estado 404.",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="El nombre de usuario del usuario a mostrar.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Información del usuario obtenida exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="email", type="string", example="correo@example.com"),
     *                 @OA\Property(property="phone", type="string", example="123456789"),
     *                 @OA\Property(property="municipality_name", type="string", example="NombreMunicipio"),
     *                 @OA\Property(property="avatar", type="string", example="url_avatar"),
     *                 @OA\Property(property="username", type="string", example="nombre_usuario"),
     *                 @OA\Property(property="name", type="string", example="Nombre"),
     *                 @OA\Property(property="gender", type="string", example="Género"),
     *                 @OA\Property(property="birth_date", type="string", example="Fecha de Nacimiento"),
     *                 @OA\Property(property="address", type="string", example="Dirección"),
     *                 @OA\Property(property="description", type="string", example="Descripción del Comercio"),
     *                 @OA\Property(property="categories_name", type="string", example="Nombre de la Categoría"),
     *                 @OA\Property(property="schedule", type="string", example="Horario"),
     *                 @OA\Property(property="active", type="string", example="Estado de Actividad")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Usuario no encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Mensaje de error interno")
     *         )
     *     )
     * )
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
     * @OA\Put(
     *     path="/user/{username}",
     *     summary="Actualiza la información de un usuario específico.",
     *     description="Comprueba que un usuario por su nombre sea de tipo costumer o commercie para luego poder actualizar los campos respectivos de cada uno.",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="El nombre de usuario del usuario a actualizar.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos de actualización del usuario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="username", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="phone", type="string"),
     *                 @OA\Property(property="municipality_name", type="string"),
     *                 @OA\Property(property="avatar", type="string"),
     *                 @OA\Property(property="banner", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="gender", type="string"),
     *                 @OA\Property(property="birth_date", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="categories_name", type="string"),
     *                 @OA\Property(property="schedule", type="string"),
     *                 @OA\Property(property="active", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Usuario actualizado Correctamente:"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="username", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="phone", type="string"),
     *                 @OA\Property(property="municipality_name", type="string"),
     *                 @OA\Property(property="avatar", type="string"),
     *                 @OA\Property(property="banner", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="gender", type="string"),
     *                 @OA\Property(property="birth_date", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="categories_name", type="string"),
     *                 @OA\Property(property="schedule", type="string"),
     *                 @OA\Property(property="active", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en la base de datos.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Error en la base de datos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Usuario no encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No autorizado")
     *         )
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, string $username)
    {
        try {
            // Elimina campos que no queremos actualizar
            $request->request->remove("username");
            $request->request->remove("phone");
            $request->request->remove("email");
            $request->request->remove("password");

            $user = User::find(Auth::user()->id);

            //campos de usuario base
            $user->name = $request->name;
            if ($request->phone && $request->phone != "null") {
                $user->phone = $request->phone;
            }
            $user->municipality_id = Municipality::where('name', '=', $request->municipality)->first()->id;

            // Guarda las imágenes si están presentes en la solicitud

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                Storage::disk('avatars')->putFileAs($user->username, $image, '/imagenPerfil.webp');
                $user->avatar = env('APP_URL').Storage::url('avatars/'.$user->username. '/imagenPerfil.webp');
            }
            if ($request->hasFile('banner')) {
                $image = $request->file('banner');
                Storage::disk('banners')->putFileAs($user->username, $image, '/imagenBanner.webp');
                $user->banner = env('APP_URL').Storage::url('banners/'.$user->username. '/imagenBanner.webp');
            }

            if ($request->password) {
                $pass1 = $request->password;
                $pass2 = $request->password_confirmation;
                if ($pass1 == $pass2) {
                    $user->password = $pass1;
                }
            }

            // Determina el rol del usuario
            if ($user->hasRole('customer')) {
                // Si el usuario es un cliente, actualiza los detalles como cliente
                $customer = Customer::where('user_id', $user->id)->first();
              
                $customer->gender = $request->gender;

                if ($request->birth_date) {
                    $customer->birth_date = $request->birth_date;
                }
                // Actualiza otros campos de ser necesario
                $updatedUser = $customer->user->makeHidden('id');
                $customer->save();
                $user->save();
            } else {
                // Si el usuario es un comercio, actualiza los detalles como comercio
                $commerce = Commerce::where('user_id', $user->id)->first();

                if ($request->description) {
                    $commerce->description = $request->description;
                }

                if ($request->schedule) {
                    $commerce->schedule = $request->schedule;
                }

                if ($request->address) {
                    $commerce->address = $request->address;
                }

                $commerce->category_id = Category::where('name', '=', $request->category)->first()->id;
                $updatedUser = $commerce->user->makeHidden('id');
                $commerce->save();
                $user->save();
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
     * @OA\Delete(
     *     path="/user/{username}",
     *     summary="Elimina un usuario específico.",
     *     description="Si el usuario es un costumer, se elimina de la base de datos directamente. Si es un Commerce, cambia el valor del campo active a false por lo que no se borra de la base de datos.",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="El nombre de usuario del usuario a eliminar.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Usuario eliminado exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en la base de datos.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Error en la base de datos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Usuario no encontrado")
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/user/{username}/posts",
     *     summary="Retorna las publicaciones de un usuario específico.",
     *     description="Este método recupera las publicaciones de un usuario específico, identificado por su nombre de usuario. Las publicaciones incluyen información como la imagen, título, descripción, tipo, fechas de inicio y fin, fecha de creación, nombre de usuario y avatar. Además, se obtienen los hashtags asociados a cada publicación.",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="El nombre de usuario del usuario del cual se desean obtener las publicaciones.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Publicaciones obtenidas exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="post_id", type="string", example="ID_de_la_publicación"),
     *                     @OA\Property(property="image", type="string", example="imagen_de_la_publicación"),
     *                     @OA\Property(property="title", type="string", example="título_de_la_publicación"),
     *                     @OA\Property(property="description", type="string", example="descripción_de_la_publicación"),
     *                     @OA\Property(property="name", type="string", example="nombre_del_tipo_de_publicación"),
     *                     @OA\Property(property="start_date", type="string", example="fecha_de_inicio_de_la_publicación"),
     *                     @OA\Property(property="end_date", type="string", example="fecha_de_finalización_de_la_publicación"),
     *                     @OA\Property(property="created_at", type="string", example="fecha_de_creación_de_la_publicación"),
     *                     @OA\Property(property="username", type="string", example="nombre_de_usuario"),
     *                     @OA\Property(property="user_id", type="string", example="ID_del_usuario"),
     *                     @OA\Property(property="avatar", type="string", example="avatar_del_usuario"),
     *                     @OA\Property(property="hashtags", type="array",
     *                         @OA\Items(type="string", example="hashtag1")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado en la base de datos.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado en la base de datos: mensaje_de_error")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en la base de datos.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error en la base de datos : mensaje_de_error")
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/user/{username}/events",
     *     summary="Retorna los eventos asociados a un usuario específico.",
     *     description="Este método recupera los eventos asociados a un usuario específico, identificado por su nombre de usuario. Los eventos incluyen información como la imagen, título, descripción, tipo, fechas de inicio y fin, fecha de creación, nombre de usuario y avatar. Además, se obtienen los hashtags asociados a cada evento.",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="El nombre de usuario del usuario del cual se desean obtener los eventos.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Eventos obtenidos exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="post_id", type="string", example="ID_del_evento"),
     *                     @OA\Property(property="image", type="string", example="imagen_del_evento"),
     *                     @OA\Property(property="title", type="string", example="título_del_evento"),
     *                     @OA\Property(property="description", type="string", example="descripción_del_evento"),
     *                     @OA\Property(property="name", type="string", example="nombre_del_tipo_de_evento"),
     *                     @OA\Property(property="start_date", type="string", example="fecha_de_inicio_del_evento"),
     *                     @OA\Property(property="end_date", type="string", example="fecha_de_finalización_del_evento"),
     *                     @OA\Property(property="created_at", type="string", example="fecha_de_creación_del_evento"),
     *                     @OA\Property(property="username", type="string", example="nombre_de_usuario"),
     *                     @OA\Property(property="user_id", type="string", example="ID_del_usuario"),
     *                     @OA\Property(property="avatar", type="string", example="avatar_del_usuario"),
     *                     @OA\Property(property="hashtags", type="array",
     *                         @OA\Items(type="string", example="hashtag1")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado en la base de datos.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado en la base de datos: mensaje_de_error")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en la base de datos.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error en la base de datos : mensaje_de_error")
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/profile",
     *     summary="Retorna el perfil del usuario autenticado.",
     *     description="Este método recupera y devuelve el perfil del usuario autenticado. Si el usuario es un cliente, se devuelve la información relacionada con el cliente, incluyendo correo electrónico, teléfono, municipio, avatar, banner, nombre de usuario, nombre, género y fecha de nacimiento. Si el usuario es un comercio, se devuelve la información relacionada con el comercio, incluyendo correo electrónico, teléfono, municipio, avatar, banner, nombre de usuario, nombre, dirección, descripción del comercio, categoría, horario, estado activo, promedio de calificación y recuento de reseñas.",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Perfil del usuario autenticado obtenido exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="email", type="string", example="correo_electrónico"),
     *                 @OA\Property(property="phone", type="string", example="número_de_teléfono"),
     *                 @OA\Property(property="municipality_name", type="string", example="nombre_del_municipio"),
     *                 @OA\Property(property="avatar", type="string", example="avatar_del_usuario"),
     *                 @OA\Property(property="banner", type="string", example="banner_del_usuario"),
     *                 @OA\Property(property="username", type="string", example="nombre_de_usuario"),
     *                 @OA\Property(property="name", type="string", example="nombre_del_usuario"),
     *                 @OA\Property(property="gender", type="string", example="género_del_usuario"),
     *                 @OA\Property(property="birth_date", type="string", example="fecha_de_nacimiento_del_usuario"),
     *                 @OA\Property(property="address", type="string", example="dirección_del_comercio"),
     *                 @OA\Property(property="description", type="string", example="descripción_del_comercio"),
     *                 @OA\Property(property="categories_name", type="string", example="nombre_de_la_categoría"),
     *                 @OA\Property(property="schedule", type="string", example="horario_del_comercio"),
     *                 @OA\Property(property="active", type="boolean", example=true),
     *                 @OA\Property(property="avg", type="string", example="promedio_de_calificación_del_comercio"),
     *                 @OA\Property(property="review_count", type="string", example="recuento_de_reseñas_del_comercio"),
     *                 @OA\Property(property="hashtags", type="array",
     *                     @OA\Items(type="string", example="hashtag1")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado: mensaje_de_error")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en la base de datos.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error en la base de datos: mensaje_de_error")
     *         )
     *     )
     * )
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
