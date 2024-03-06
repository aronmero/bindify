<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Crea 10 tokens de verificación de ejemplo
        for ($i = 1; $i <= 10; $i++) {
            DB::table('verification_tokens')->insert([
                'token' => "token_" . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        // Municipios
        for ($i = 1; $i <= 30; $i++) {
            DB::table('municipalities')->insert([
                'nombre' => 'Municipio ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Categorias
        for ($i = 1; $i <= 30; $i++) {
            DB::table('categories')->insert([
                'name' => 'Categoria ' . $i,
                'description' => 'Descripción de la categoría ' . $i,
                'active' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Hashtags
        for ($i = 1; $i <= 30; $i++) {
            DB::table('hashtags')->insert([
                'name' => 'hashtag_' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Usuarios
        for ($i = 1; $i <= 30; $i++) {
            DB::table('users')->insert([
                'email' => 'usuario' . $i . '@example.com',
                'password' => bcrypt('password' . $i),
                'phone' => '123456789' . $i,
                'municipality_id' => rand(1, 30),
                'avatar' => 'avatar_' . $i . '.jpg',
                'username' => 'usuario_' . $i,
                'nombre' => 'Nombre Usuario ' . $i,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

         // Comercios
         for ($i = 1; $i <= 30; $i++) {

            if ($i<11 && $i>0) {
                DB::table('commerces')->insert([
                    'user_id' => rand(1, 30),
                    'address' => 'Dirección del comercio ' . $i,
                    'description' => 'Descripción del comercio ' . $i,
                    'verification_token_id' => $i,
                    'category_id' => rand(1, 30),
                    'verificated' => rand(0, 1),
                    'active' => rand(0, 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }else{
                DB::table('commerces')->insert([
                    'user_id' => rand(1, 30),
                    'address' => 'Dirección del comercio ' . $i,
                    'description' => 'Descripción del comercio ' . $i,
                    'category_id' => rand(1, 30),
                    'verificated' => rand(0, 1),
                    'active' => rand(0, 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
        }

        // Clientes
        for ($i = 1; $i <= 30; $i++) {
            DB::table('customers')->insert([
                'user_id' => rand(1, 30),
                'gender' => rand(0, 1) ? 'Male' : 'Female',
                'birth_date' => now()->subYears(rand(18, 70)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Notificaciones
        for ($i = 1; $i <= 30; $i++) {
            DB::table('notifications')->insert([
                'user_id' => rand(1, 30),
                'content' => 'Contenido de la notificación ' . $i,
                'seen' => rand(0, 1),
                'link' => 'Enlace de la notificación ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('post_types')->insert([
            'name' => 'Tipo de Publicación 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('post_types')->insert([
            'name' => 'Tipo de Publicación 2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Posts
        for ($i = 1; $i <= 30; $i++) {
            DB::table('posts')->insert([
                'image' => 'post_' . $i . '.jpg',
                'title' => 'Título del Post ' . $i,
                'description' => 'Descripción del Post ' . $i,
                'post_type_id' => rand(1, 2), // Ajusta el rango según los tipos de publicaciones disponibles en tu sistema
                'start_date' => now(),
                'end_date' => now()->addDays(rand(1, 30)), // Fecha de finalización aleatoria dentro de los próximos 30 días
                'active' => rand(0, 1), // Activo o no aleatorio
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Reviews
        for ($i = 1; $i <= 30; $i++) {
            DB::table('reviews')->insert([
                'user_id' => rand(1, 30), // ID de usuario aleatorio
                'commerce_id' => rand(1, 30), // ID de comercio aleatorio
                'comment' => 'Comentario del usuario ' . $i . ' sobre el comercio ' . $i,
                'note' => rand(1, 5), // Calificación aleatoria de 1 a 5
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seeder for commerces-hashtags
        for ($i = 1; $i <= 10; $i++) {
            DB::table('commerces-hashtags')->insert([
                'commerce_id' => rand(1, 20),
                'hashtag_id' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seeder for posts-hashtags
        for ($i = 1; $i <= 10; $i++) {
            DB::table('posts-hashtags')->insert([
                'post_id' => rand(1, 20),
                'hashtag_id' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Comentarios
        for ($i = 1; $i <= 30; $i++) {
            DB::table('comments')->insert([
                'user_id' => rand(1, 30),
                'post_id' => rand(1, 30),
                'content' => 'Contenido del comentario ' . $i,
                'active' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
    }

}
