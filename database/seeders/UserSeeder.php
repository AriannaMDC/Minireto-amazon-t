<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'usuari' => 'depresio',
                'nom' => 'Pepito de los Palotes',
                'email' => 'depresio@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'vendedor',
                'img' => 'public\images\users\user_placeholder.png',
                'receive_info' => false,
            ],
            [
                'id' => 2,
                'usuari' => 'ansietat',
                'nom' => 'Manolita de los Imanes',
                'email' => 'manolita@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'vendedor',
                'img' => 'public\images\users\user_placeholder.png',
                'receive_info' => true,
            ],
            [
                'id' => 3,
                'usuari' => 'tristesa',
                'nom' => 'Jose de los Josepos',
                'email' => 'josepos@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'vendedor',
                'img' => 'public\images\users\user_placeholder.png',
                'receive_info' => false,
            ],
            [
                'id' => 4,
                'usuari' => 'client',
                'nom' => 'Client User',
                'email' => 'client@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'client',
                'img' => 'public\images\users\user_placeholder.png',
                'receive_info' => true,
            ],
            [
                'id' => 5,
                'usuari' => 'admin',
                'nom' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'admin',
                'img' => 'public\images\users\user_placeholder.png',
                'receive_info' => false,
            ],
        ]);
    }
}
