<?php

namespace Database\Seeders;

use App\Models\Post_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Post_typesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post_type::create([
            'name' => 'Oferta',
        ]);
        Post_type::create([
            'name' => 'Evento',
        ]);
    }
}
