<?php

namespace Database\Seeders;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Run role seeder first to ensure roles exist
        $this->call([
            RoleSeeder::class,
            ProductSeeder::class,
        ]);

        // Create default admin user
        $admin = User::create([
            'name' => 'Coeursonn',
            'username' => 'admin',
            'email' => 'Slovengama@gmail.com',
            'password' => Hash::make('qwertyuiop'),
        ]);
        $admin->assignRole('admin');

        // Create sample products
        Product::create([
            'name' => 'Parfum Dior Sauvage',
            'description' => 'Un parfum frais et intense pour homme.',
            'price' => 89.99,
            'image' => 'https://example.com/images/dior_sauvage.jpg',
        ]);

        Product::create([
            'name' => 'Crème Hydratante Nivea',
            'description' => 'Hydratation intense pour une peau douce.',
            'price' => 12.99,
            'image' => 'https://example.com/images/nivea_creme.jpg',
        ]);

        Product::create([
            'name' => 'Rouge à Lèvres MAC',
            'description' => 'Une couleur intense et longue tenue.',
            'price' => 24.99,
            'image' => 'https://example.com/images/mac_rouge.jpg',
        ]);
    }
}
