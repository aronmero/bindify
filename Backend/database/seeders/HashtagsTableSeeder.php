<?php

namespace Database\Seeders;

use App\Models\Hashtag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HashtagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cantidad = 20;

        for ($i = 0; $i < $cantidad; $i++) {
            Hashtag::factory()->create();
        }
    }
}
