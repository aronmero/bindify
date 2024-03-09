<?php

namespace Database\Seeders;

use App\Models\Commerce;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommercesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cantidad = 20;

        for ($i = 0; $i < $cantidad; $i++) {
            Commerce::factory()->create();
        }
    }
}
