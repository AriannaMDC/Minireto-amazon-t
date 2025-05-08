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
                'descripcion' => 'Vendedor especializado en electrónica y gadgets tecnológicos.',
                'img' => 'images/users/user_placeholder.png',
                'direccio' => null,
                'comarca' => null,
                'municipi' => null,
                'provincia' => null,
                'telefon' => null,
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
                'descripcion' => 'Vendedora de productos artesanales y hechos a mano con más de 10 años de experiencia.',
                'img' => 'images/users/user_placeholder.png',
                'direccio' => 'Carrer Menor, 2',
                'comarca' => 'Vallès Occidental',
                'municipi' => 'Sabadell',
                'provincia' => 'Barcelona',
                'telefon' => '678123456',
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
                'descripcion' => 'Vendedor de productos gourmet y alimentación de proximidad.',
                'img' => 'images/users/user_placeholder.png',
                'direccio' => 'Avinguda Diagonal, 3',
                'comarca' => 'Barcelonès',
                'municipi' => 'Hospitalet de Llobregat',
                'provincia' => 'Barcelona',
                'telefon' => '654789123',
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
                'descripcion' => null,
                'img' => 'images/users/user_placeholder.png',
                'direccio' => 'Plaça Catalunya, 4',
                'comarca' => 'Maresme',
                'municipi' => 'Mataró',
                'provincia' => 'Barcelona',
                'telefon' => '611223344',
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
                'descripcion' => null,
                'img' => 'images/users/user_placeholder.png',
                'direccio' => 'Via Augusta, 5',
                'comarca' => 'Garraf',
                'municipi' => 'Sitges',
                'provincia' => 'Tarragona',
                'telefon' => '699887766',
                'receive_info' => false,
            ],
        ]);
    }
}
