<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            'name' => 'Parfum Dior Sauvage',
            'description' => 'Un parfum frais et intense pour homme.',
            'price' => 89.99,
            'image' => 'https://example.com/images/dior_sauvage.jpg',
            'category' => 'Parfums', // <-- TRÈS IMPORTANT
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
