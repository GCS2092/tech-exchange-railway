<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Définis un tableau des utilisateurs à créer
        $users = [
            [
                'name'       => 'Coeurson',
                'email'      => 'Slovengama@gmail.com',
                'password'   => Hash::make('qwertyuiop'),
                'role'       => 'admin',
                'username'   => 'coeursonn_admin',
            ],
            [
                'name'       => 'Stem',
                'email'      => 'Stemk2151@gmail.com',
                'password'   => Hash::make('asdfghjkl'),
                'role'       => 'livreur',
                'username'   => 'client_user',
            ],
        ];

        foreach ($users as $userData) {
            // Vérifie si l'email existe déjà
            $exists = DB::table('users')
                        ->where('email', $userData['email'])
                        ->exists();

            if (! $exists) {
                // Ajoute les timestamps et insère
                DB::table('users')->insert(array_merge($userData, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
