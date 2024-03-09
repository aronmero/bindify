<?php

namespace Database\Seeders;

use App\Models\Verification_token;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Verification_tokensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cantidad = 12;

        for ($i = 0; $i < $cantidad; $i++) {
            Verification_token::factory()->create();
        }
    }
}
